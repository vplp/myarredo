<?php

namespace frontend\modules\catalog\widgets\product;

use yii\base\Widget;
use frontend\modules\catalog\models\{
    Product, ProductLang
};

/**
 * Class ProductsNoveltiesOnMain
 *
 * @package frontend\modules\catalog\widgets\product
 */
class ProductsNoveltiesOnMain extends Widget
{
    /**
     * @var string
     */
    public $view = 'products_novelties_on_main';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = Product::findBaseArray()
            ->select([
                Product::tableName() . '.id',
                Product::tableName() . '.alias',
                Product::tableName() . '.image_link',
                Product::tableName() . '.factory_id',
                Product::tableName() . '.bestseller',
                ProductLang::tableName() . '.title',
            ])
            ->andWhere([Product::tableName() . '.novelty' => '1'])
            ->orderBy(Product::tableName() . '.updated_at DESC')
            ->cache(7200)
            ->all();

        $i = 0;
        $_models = [];

        foreach ($this->models as $key => $model) {
            if ($key % 8 == 0) {
                $i++;
            }
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
