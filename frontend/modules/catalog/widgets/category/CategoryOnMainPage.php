<?php

namespace frontend\modules\catalog\widgets\category;

use Yii;
use yii\base\Widget;
use frontend\modules\catalog\models\{Category, CategoryLang, Factory, Product};

/**
 * Class CategoryOnMainPage
 *
 * @package frontend\modules\catalog\widgets\category
 */
class CategoryOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'category_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->models = Category::getDb()->cache(function ($db) {
            return Category::findBase()
                ->innerJoinWith(["product"], false)
                ->innerJoinWith(["product.lang"], false)
                ->innerJoinWith(["product.factory"], false)
                ->andFilterWhere([
                    Product::tableName() . '.published' => '1',
                    Product::tableName() . '.deleted' => '0',
                    Product::tableName() . '.removed' => '0',
                    Factory::tableName() . '.published' => '1',
                    Factory::tableName() . '.deleted' => '0',
                    //Factory::tableName() . '.show_for_' . DOMAIN_TYPE => '1',
                ])
                ->andWhere([Category::tableName() . '.popular' => '1'])
                ->andFilterWhere(['IN', Factory::tableName() . '.producing_country_id', [4]])
                ->select([
                    Category::tableName() . '.id',
                    Category::tableName() . '.alias',
                    Category::tableName() . '.alias_en',
                    Category::tableName() . '.alias_it',
                    Category::tableName() . '.alias_de',
                    Category::tableName() . '.alias_fr',
                    Category::tableName() . '.alias_he',
                    Category::tableName() . '.image_link',
                    Category::tableName() . '.image_link2',
                    Category::tableName() . '.image_link3',
                    Category::tableName() . '.image_link_com',
                    Category::tableName() . '.image_link2_com',
                    Category::tableName() . '.image_link_de',
                    Category::tableName() . '.image_link2_de',
                    Category::tableName() . '.image_link_fr',
                    Category::tableName() . '.image_link2_fr',
                    Category::tableName() . '.position',
                    CategoryLang::tableName() . '.title',
                    'count(' . Category::tableName() . '.id) as count'
                ])
                ->groupBy(Category::tableName() . '.id')
                ->all();
        }, 60 * 60);
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
