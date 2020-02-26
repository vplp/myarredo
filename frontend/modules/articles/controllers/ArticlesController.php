<?php

namespace frontend\modules\articles\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
//
use frontend\components\BaseController;
use frontend\modules\articles\models\Article;
//
use thread\actions\{
    ListQuery, RecordView
};

/**
 * Class ArticlesController
 *
 * @package frontend\modules\articles\controllers
 */
class ArticlesController extends BaseController
{
    public $label = "Articles";

    public $title = "Articles";

    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                ],
            ],
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['index'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    return Article::findBase()
                        ->alias(Yii::$app->request->get('alias'))
                        ->max(Article::tableName() . '.updated_at');
                },
                'etagSeed' => function ($action, $params) {
                    $model = Article::findByAlias(Yii::$app->request->get('alias'));
                    return serialize([
                        $model['lang']['title'],
                        $model['lang']['content']
                    ]);
                }
            ];

            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['list'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    return Article::findBase()->max(Article::tableName() . '.updated_at');
                },
                'etagSeed' => function ($action, $params) {
                    $model = Article::findBase()
                        ->orderBy([Article::tableName() . '.updated_at' => SORT_DESC])
                        ->one();
                    return serialize([
                        $model['lang']['title'],
                        $model['lang']['content']
                    ]);
                },
            ];
        }

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'list' => [
                'class' => ListQuery::class,
                'query' => Article::findBase(),
                'recordOnPage' => $this->module->itemOnPage,
            ],
            'view' => [
                'class' => RecordView::class,
                'modelClass' => Article::class,
                'methodName' => 'findByAlias',
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (Yii::$app->city->getCityId() != 4) {
            return $this->redirect('https://' . 'www.myarredo.ru' . Url::toRoute('/articles/articles/list'), 301);
        }

        $this->title = Yii::t('app', 'Articles');

        return parent::beforeAction($action);
    }
}
