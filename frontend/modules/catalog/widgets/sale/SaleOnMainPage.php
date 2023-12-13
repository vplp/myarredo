<?php

namespace frontend\modules\catalog\widgets\sale;

use Yii;
use yii\base\Widget;
use frontend\modules\catalog\models\{
    Sale, SaleLang, Factory
};
use frontend\modules\location\models\{
    Country, City
};

/**
 * Class SaleOnMainPage
 *
 * @package frontend\modules\catalog\widgets\sale
 */
class SaleOnMainPage extends Widget
{
    /**
     * @var string
     */
    public $view = 'sale_on_main_page';

    /**
     * @var object
     */
    protected $models = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $country_id = Yii::$app->city->getCountryId();
        $city_id = Yii::$app->city->getCityId();

        $this->models = Sale::getDb()->cache(function ($db) use ($country_id, $city_id) {
            return Sale::findBase()
                ->select([
                    Sale::tableName() . '.id',
                    Sale::tableName() . '.alias',
                    Sale::tableName() . '.image_link',
                    Sale::tableName() . '.factory_id',
                    Sale::tableName() . '.price',
                    Sale::tableName() . '.price_new',
                    Sale::tableName() . '.currency',
                    Sale::tableName() . '.country_id',
                    Sale::tableName() . '.city_id',
                    Sale::tableName() . '.position',
                    SaleLang::tableName() . '.title',
                ])
                ->innerJoinWith(["country", "city", "factory"])
                ->andFilterWhere(['IN', Country::tableName() . '.id', $country_id])
                ->andFilterWhere(['IN', City::tableName() . '.id', $city_id])
                ->andWhere([
                    'or',
                    Sale::tableName() . '.on_main = \'1\'',
                    Sale::tableName() . '.on_main = \'0\'',
                ])
                ->limit(8)
                ->asArray()
                ->all();
        }, 7200);
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!empty($this->models)) {
            return $this->render(
                $this->view,
                [
                    'models' => $this->models
                ]
            );
        }
    }
}
