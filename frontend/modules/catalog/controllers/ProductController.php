<?php

namespace frontend\modules\catalog\controllers;

use yii\filters\VerbFilter;
//
use thread\actions\RecordView;
//
use frontend\modules\catalog\models\Product;
use frontend\components\BaseController;

/**
 * Class ProductController
 *
 * @package frontend\modules\news\controllers
 */
class ProductController extends BaseController
{
    public $title = "Product";
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
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => RecordView::class,
                'modelClass' => Product::class,
                'methodName' => 'findByAlias',
            ],
        ];
    }
}