<?php

namespace frontend\modules\page\controllers;

use frontend\components\BaseController;
use Yii;
use yii\web\NotFoundHttpException;
use frontend\modules\page\models\Page;

/**
 * Class PageController
 *
 * @package frontend\modules\page\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class PageController extends BaseController
{
    public $title = "Page";
    public $layout = "/page";
    public $defaultAction = 'index';
    public $model;
    
    

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
                    'contacts' => ['get'],
                    'view' => ['get'],
                ],
            ]
        ];
    }

    /**
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "/start";
        return $this->run('view', ['alias' => 'start']);
    }

    /**
     *
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($alias)
    {
        $model = Page::findByAlias($alias);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        //layouts
        if ($model->alias == 'contacts') {
            $this->layout = 'contacts';
            $view = 'index';
        } else if ($model->alias == 'about') {
            $this->layout = 'about';
            $view = 'index';
        } else {
            $this->layout = 'privacy-policy';
            $view = 'default';
        }

        $this->model = $model;

        return $this->render($view, [
            'model' => $model,
        ]);
    }

}
