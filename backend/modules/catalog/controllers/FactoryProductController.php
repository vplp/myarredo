<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use backend\modules\catalog\models\{
    FactoryProduct, FactoryProductLang, search\FactoryProduct as filterFactoryProduct
};

/**
 * Class FactoryProductController
 *
 * @package backend\modules\catalog\controllers
 */
class FactoryProductController extends ProductController
{
    public $model = FactoryProduct::class;
    public $modelLang = FactoryProductLang::class;
    public $filterModel = filterFactoryProduct::class;

    public $title = 'Factory product';
    public $name = 'Factory product';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'view' => '/product/list',
                'layout' => 'list-factory-product',
            ],
            'trash' => [
                'view' => '/product/trash'
            ],
            'update' => [
                'view' => '/product/_form'
            ],
        ]);
    }
}
