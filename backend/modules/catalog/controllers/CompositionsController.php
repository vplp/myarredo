<?php

namespace backend\modules\catalog\controllers;

use thread\app\base\controllers\BackendController;
use backend\modules\catalog\models\{
    Product, ProductLang, search\Product as filterProduct
};

/**
 * Class CompositionsController
 *
 * @package backend\modules\catalog\controllers
 */
class CompositionsController extends BackendController
{
    public $model = Product::class;
    public $modelLang = ProductLang::class;
    public $filterModel = filterProduct::class;
    public $title = 'Compositions';
    public $name = 'compositions';
}