<?php

namespace frontend\modules\catalog\widgets\product;

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
    private $category = [];

    /**
     * @var object
     */
    private $types = [];

    /**
     * @var object
     */
    private $style = [];

    /**
     * @var object
     */
    private $factory = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->category = Category::getAllWithFilter();
        $this->types = Types::findBase()->all();
        $this->style = Specification::findBase()->andWhere(['parent_id' => 9])->all();
        $this->factory = Factory::findBase()->all();
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