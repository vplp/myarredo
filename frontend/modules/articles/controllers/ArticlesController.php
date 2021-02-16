<?php

namespace frontend\modules\articles\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use frontend\components\BaseController;
use frontend\modules\articles\models\Article;
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
                    $model = Article::findByAlias(Yii::$app->request->get('alias'));
                    return $model != null ? $model['updated_at'] : time();
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
                    $model = Article::findLastUpdated();
                    return $model != null ? $model['updated_at'] : time();
                },
                'etagSeed' => function ($action, $params) {
                    $model = Article::findLastUpdated();
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
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->title = Yii::t('app', 'Articles');

        return parent::beforeAction($action);
    }
}
