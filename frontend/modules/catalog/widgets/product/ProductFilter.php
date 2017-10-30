<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Widget;
//
use frontend\modules\catalog\models\{
    Category,
    Factory,
    ProductRelCategory,
    search\Product,
    Types,
    Specification
};


/**
 * Class ProductFilter
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductFilter extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_filter';

    /**
     * @var object
     */
    public $category = [];

    /**
     * @var object
     */
    public $category_counts = [];

    /**
     * @var object
     */
    public $types = [];

    /**
     * @var object
     */
    public $style = [];

    /**
     * @var object
     */
    public $factory = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
//        $model = new Product();
//
//        $subQuery = $model->getSubQuery(Yii::$app->catalogFilter->params);
//
//        $category_counts = ProductRelCategory::getCounts($subQuery);
//
//        $c = $this->category;
//        foreach ($c as $k => $cc) {
//            if (!isset($category_counts[$cc['id']]) || $category_counts[$cc['id']]['count'] <= 0) {
//                unset($c[$k]);
//            }
//        }
//
//        $this->category = $c;
//        $this->category_counts = $category_counts ?? [];
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, [
            'category' => $this->category,
            //'category_counts' => $this->category_counts,
            'types' => $this->types,
            'style' => $this->style,
            'factory' => $this->factory,
            'filter' => Yii::$app->catalogFilter->params
        ]);
    }
}