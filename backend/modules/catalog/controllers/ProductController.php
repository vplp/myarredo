<?php

namespace backend\modules\catalog\controllers;

use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use thread\actions\AttributeSwitch;
use backend\modules\catalog\models\{
    Product, ProductLang, search\Product as filterProduct
};

/**
 * Class ProductController
 *
 * @package backend\modules\catalog\controllers
 */
class ProductController extends BackendController
{
    public $model = Product::class;
    public $modelLang = ProductLang::class;
    public $filterModel = filterProduct::class;
    public $title = 'Product';
    public $name = 'product';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'popular' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'popular',
                'redirect' => $this->defaultAction,
            ],
            'novelty' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'novelty',
                'redirect' => $this->defaultAction,
            ],
            'bestseller' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'bestseller',
                'redirect' => $this->defaultAction,
            ],
            'onmain' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'onmain',
                'redirect' => $this->defaultAction,
            ],
            'removed' => [
                'class' => AttributeSwitch::class,
                'modelClass' => $this->model,
                'attribute' => 'removed',
                'redirect' => $this->defaultAction,
            ],
        ]);
    }
}
