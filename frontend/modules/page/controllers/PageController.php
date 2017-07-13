<?php

namespace frontend\modules\page\controllers;

use Yii;
use yii\filters\VerbFilter;
//
use thread\actions\RecordView;
//
use frontend\components\BaseController;
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
     * @return array
     */
    public function actions()
    {
        return [
            'view' => [
                'class' => RecordView::class,
                'modelClass' => Page::class,
                'methodName' => 'findByAlias'
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

}
