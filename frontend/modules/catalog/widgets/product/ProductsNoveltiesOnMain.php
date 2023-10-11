<?php

namespace frontend\modules\catalog\widgets\product;

use Yii;
use yii\base\Widget;
use frontend\modules\catalog\models\{
    Product, ProductLang, ProductNoveltyRelCity
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
                Product::tableName() . '.collections_id',
                Product::tableName() . '.alias',
                Product::tableName() . '.alias_en',
                Product::tableName() . '.alias_it',
                Product::tableName() . '.alias_de',
                Product::tableName() . '.alias_fr',
                Product::tableName() . '.alias_he',
                Product::tableName() . '.image_link',
                Product::tableName() . '.factory_id',
                Product::tableName() . '.bestseller',
                ProductLang::tableName() . '.title',
            ])
            ->innerJoinWith(['noveltyRelCities'], false)
            ->andFilterWhere([ProductNoveltyRelCity::tableName() . '.location_city_id' => Yii::$app->city->getCityId()])
            ->limit(100)
            ->cache(7200)
            ->all();

        $this->models = array_merge($this->models, Product::findBaseArray()
            ->select([
                Product::tableName() . '.id',
                Product::tableName() . '.collections_id',
                Product::tableName() . '.alias',
                Product::tableName() . '.alias_en',
                Product::tableName() . '.alias_it',
                Product::tableName() . '.alias_de',
                Product::tableName() . '.alias_fr',
                Product::tableName() . '.alias_he',
                Product::tableName() . '.image_link',
                Product::tableName() . '.factory_id',
                Product::tableName() . '.bestseller',
                ProductLang::tableName() . '.title',
            ])
            ->andWhere([Product::tableName() . '.novelty' => '1'])
            ->groupBy(Product::tableName() . '.collections_id')
            ->orderBy(Product::tableName() . '.updated_at DESC')
            ->limit(100)
            ->cache(7200)
            ->all());

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
