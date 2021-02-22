<?php

namespace frontend\modules\news\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use thread\actions\ListQuery;
use frontend\components\BaseController;
use frontend\modules\news\models\{
    Article, Group
};

/**
 * Class ListController
 *
 * @package frontend\modules\news\controllers
 */
class ListController extends BaseController
{
    public $label = "News";
    public $title = "News";
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
                    return ($model != null && $model['lang']) ? serialize([
                        $model['lang']['title'],
                        $model['lang']['content']
                    ]) : '';
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
                    return ($model != null && $model['lang']) ? serialize([
                        $model['lang']['title'],
                        $model['lang']['content']
                    ]) : '';
                },
            ];
        }

        return $behaviors;
    }

    /**
     * @return array[]
     * @throws NotFoundHttpException
     */
    public function actions()
    {
        $g = function () {
            $r = 0;
            if (Yii::$app->request->get('alias')) {
                $item = Group::findByAlias(Yii::$app->request->get('alias'));

                if ($item == null) {
                    throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
                }

                $r = $item['id'];

            }
            return $r;
        };

        $group = $g();

        return [
            'index' => [
                'class' => ListQuery::class,
                'query' => ($group)
                    ? Article::findBase()->group_id($group)
                    : Article::findBase(),
                'recordOnPage' => $this->module->itemOnPage,
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->title = Yii::t('app', 'News');

        $item = (isset($_GET['alias']))
            ? Group::findByAlias($_GET['alias'])
            : null;

        if ($item != null) {
            $this->title = $item['lang']['title'];
        }

        return parent::beforeAction($action);
    }
}
