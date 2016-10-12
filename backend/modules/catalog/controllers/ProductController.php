<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\catalog\models\{
    Product, ProductLang, search\Product as filterProductModel
};

/**
 * Class ProductController
 *
 * @package backend\modules\catalog\controllers
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class ProductController extends BackendController
{
    public $model = Product::class;
    public $modelLang = ProductLang::class;
    public $filterModel = filterProductModel::class;
    public $title = 'Product';
    public $name = 'product';
}