<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\catalog\models\{
    Product,
    search\Product as filterProduct
};
use thread\actions\ListModel;
use thread\app\base\controllers\BackendController;

/**
 * Class ProductWithoutPriceListController
 *
 * @package backend\modules\catalog\controllers
 */
class ProductWithoutPriceListController extends BackendController
{
    public $model = Product::class;
    public $filterModel = filterProduct::class;

    public $title = 'Product without price list';

    public $name = 'Product without price list';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'catalogEditor'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'layout' => 'list-countries-furniture'
            ],
        ]);
    }
}
