<?php

namespace frontend\modules\page\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use frontend\components\BaseController;
use frontend\modules\page\models\Page;

/**
 * Class PageController
 *
 * @package frontend\modules\page\controllers
 */
class PageController extends BaseController
{
    public $title = "";

    public $defaultAction = 'index';

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'contacts' => ['get'],
                    'view' => ['get'],
                ],
            ]
        ];

        if (Yii::$app->getUser()->isGuest) {
            $behaviors[] = [
                'class' => \yii\filters\HttpCache::class,
                'only' => ['view'],
                'cacheControlHeader' => 'must-revalidate, max-age=86400',
                'lastModified' => function ($action, $params) {
                    $model = Page::findByAlias(Yii::$app->request->get('alias'));
                    return $model != null ? $model['updated_at'] : time();
                },
                'etagSeed' => function ($action, $params) {
                    $model = Page::findByAlias(Yii::$app->request->get('alias'));
                    return $model != null ? serialize([
                            $model['lang']['title'],
                            $model['lang']['content']
                        ]) : '';
                },
            ];
        }

        return $behaviors;
    }
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($alias)
    {
        $model = Page::findByAlias($alias);

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        Yii::$app->metatag->registerModel($model)->render();

        $this->title = Yii::$app->metatag->seo_title ?? $model['lang']['title'];

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "/start";
        return $this->run('view', ['alias' => 'start']);
    }
}
