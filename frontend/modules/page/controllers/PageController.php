<?php

namespace frontend\modules\page\controllers;

use Yii;
use yii\filters\VerbFilter;
//
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
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'contacts' => ['get'],
                    'view' => ['get'],
                ],
            ]
        ];
    }

    /**
     * @param string $alias
     * @return string
     */
    public function actionView($alias)
    {
        $model = Page::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        $this->title = $model['lang']['title'];

        Yii::$app->metatag->registerModel($model);

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
