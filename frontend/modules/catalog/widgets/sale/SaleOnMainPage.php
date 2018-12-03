<?php

namespace frontend\modules\catalog\widgets\sale;

use Yii;
use yii\base\Widget;
//
use frontend\modules\catalog\models\Sale;
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
        $this->models = Sale::findBase()
            ->innerJoinWith(["country", "city"])
            ->andFilterWhere(['IN', Country::tableName() . '.id', Yii::$app->city->getCountryId()])
            ->andFilterWhere(['IN', City::tableName() . '.id', Yii::$app->city->getCityId()])
//            ->andWhere([Sale::tableName() . '.on_main' => '1'])
            ->andWhere([
                'or',
                Sale::tableName() . '.on_main = \'1\'',
                Sale::tableName() . '.on_main = \'0\'',
//                City::tableName() . '.id = ' . Yii::$app->city->getCityId(),
//                Country::tableName() . '.id = ' . Yii::$app->city->getCountryId(),
            ])
            //->cache(7200)
            ->limit(12)
            ->all();

        $_models = [];

        if ($this->models != null) {
            $i = 0;
            foreach ($this->models as $key => $model) {
                if ($key % 3 == 0) {
                    $i++;
                }
                $_models[$i][] = $model;
            }
            $this->models = $_models;
        }
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
