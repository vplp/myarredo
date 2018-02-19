<?php

namespace frontend\modules\catalog\widgets\product;

use yii\base\Widget;
use frontend\modules\catalog\models\Product;

/**
 * Class ProductNovelty
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductNovelty extends Widget
{
    /**
     * @var string
     */
    public $view = 'product_novelty';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = Product::findBase()
            ->andWhere(['onmain' => '1'])
            ->asArray()
            ->cache(7200)
            ->all();

        $i = 0;
        $_models = [];

        foreach ($this->models as $key => $model) {
            if ($key % 5 == 0)
                $i++;
            $_models[$i][] = $model;
        }

        $this->models = $_models;
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'models' => $this->models
            ]
        );
    }
}