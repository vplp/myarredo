<?php

namespace frontend\modules\catalog\controllers;

use thread\actions\RecordView;
use frontend\modules\catalog\models\Product;

/**
 * Class ProductController
 *
 * @package frontend\modules\catalog\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class ProductController extends \frontend\components\BaseController
{
    public $title = "Product";
    public $layout = "@app/layouts/column1";
    public $defaultAction = 'index';

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
                ],
            ],
        ];
    }

    /**
     *
     * @return array
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => RecordView::class,
                'modelClass' => Product::class,
                'methodName' => 'findByAlias',
                'view' => 'product',
            ],
        ];
    }

    /**
     *
     * @param string $action
     * @return boollean
     */
    public function beforeAction($action)
    {
        $item = (isset($_GET['alias']))
            ? Product::findByAlias($_GET['alias'])
            : null;

        if ($item !== null) {
            $this->title = $item['lang']['title'];
        }

//        $this->breadcrumbs['catalog'] = [
//            'label' => $item['lang']['title'],
//            'url' => $item->getUrl()
//        ];

        $this->breadcrumbs[] = $item['lang']['title'];

        return parent::beforeAction($action);
    }
}
