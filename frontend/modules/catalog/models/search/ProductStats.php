<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\catalog\models\{
    ProductStats as ProductStatsModel
};

/**
 * Class ProductStats
 *
 * @package frontend\modules\catalog\models\search
 */
class ProductStats extends ProductStatsModel
{
    public $factory_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['city_id', 'factory_id'], 'integer'],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        if (isset($params['factory_id'])) {
            $query->andWhere([Product::tableName() . '.factory_id' => $params['factory_id']]);
        }

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductStatsModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
