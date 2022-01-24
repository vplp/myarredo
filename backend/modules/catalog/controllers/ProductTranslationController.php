<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\catalog\models\{
    Product,
    ProductLang,
    search\Product as filterProduct
};
use thread\actions\ListModel;
use thread\app\base\controllers\BackendController;

/**
 * Class ProductTranslationController
 *
 * @package backend\modules\catalog\controllers
 */
class ProductTranslationController extends BackendController
{
    public $model = Product::class;
    public $modelLang = ProductLang::class;
    public $filterModel = filterProduct::class;

    public $title = 'Product translation';

    public $name = 'Product translation';

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
            'create' => null,
            'update' => [
                'scenario' => 'translation'
            ],
        ]);
    }
}
