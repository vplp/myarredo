<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Widget;
//
use frontend\modules\catalog\models\{
    Category, Factory, Types, Specification
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
        //* !!! */ echo  '<pre style="color:red;">'; print_r(Yii::$app->catalogFilter->params); echo '</pre>'; /* !!! */

//        $this->category = Category::getAllWithFilter(Yii::$app->catalogFilter->params);
//        $this->types = Types::getAllWithFilter(Yii::$app->catalogFilter->params);
//        $this->style = Specification::getAllWithFilter(Yii::$app->catalogFilter->params);
//        $this->factory = Factory::getAllWithFilter(Yii::$app->catalogFilter->params);
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->view, [
            'category' => $this->category,
            'types' => $this->types,
            'style' => $this->style,
            'factory' => $this->factory,
        ]);
    }
}