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
    public $start_date;
    public $end_date;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['city_id', 'factory_id'], 'integer'],
            [['start_date', 'end_date'], 'string', 'max' => 10],
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

        if (isset($params['factory_id']) && $params['factory_id'] > 0) {
            $query->andWhere([Product::tableName() . '.factory_id' => $params['factory_id']]);
        }

        if (isset($params['city_id']) && $params['city_id'] > 0) {
            $query->andWhere([self::tableName() . '.city_id' => $params['city_id']]);
        }

        if (isset($params['start_date']) && $params['start_date'] != '' && isset($params['end_date']) && $params['end_date'] != '') {
            $query->andWhere(['>=', self::tableName() . '.created_at', strtotime($params['start_date']. ' 0:00')]);
            $query->andWhere(['<=', self::tableName() . '.created_at', strtotime($params['end_date']. ' 23:59')]);
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
