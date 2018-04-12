<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{
    ProductStatsDays as ProductStatsModel
};

/**
 * Class ProductStatsDays
 *
 * @package frontend\modules\catalog\models\search
 */
class ProductStatsDays extends ProductStatsModel
{
    public $start_date;
    public $end_date;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['product_id', 'country_id', 'city_id', 'factory_id'], 'integer'],
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
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        if (isset($params['factory_id']) && $params['factory_id'] > 0) {
            $query->andWhere([self::tableName() . '.factory_id' => $params['factory_id']]);
        }

        if (isset($params['product_id']) && $params['product_id'] > 0) {
            $query->andWhere([self::tableName() . '.product_id' => $params['product_id']]);
        }

        if (isset($params['start_date']) && $params['start_date'] != '' && isset($params['end_date']) && $params['end_date'] != '') {
            $query->andWhere(['>=', self::tableName() . '.date', strtotime($params['start_date'] . ' 0:00')]);
            $query->andWhere(['<=', self::tableName() . '.date', strtotime($params['end_date'] . ' 23:59')]);
        }

        if (isset($params['country_id']) && $params['country_id'] > 0 && !$params['city_id']) {

            $model = City::findAll(['country_id' => $params['country_id']]);

            if ($model != null) {
                $city_id = [];
                foreach ($model as $city) {
                    $city_id[] = $city['id'];
                }
                $query->andFilterWhere(['IN', self::tableName() . '.city_id', $city_id]);
            }
        } elseif (isset($params['city_id']) && $params['city_id'] > 0) {
            $query->andFilterWhere(['IN', self::tableName() . '.city_id', $params['city_id']]);
        }

        if ($params['action'] == 'view' && isset($params['city_id']) && $params['city_id'] == 0) {
            $query->select([
                self::tableName() . '.product_id',
                self::tableName() . '.date',
                'count(' . self::tableName() . '.date) as count',
                'sum(' . self::tableName() . '.views) as views'
            ]);
            $query->groupBy(self::tableName() . '.date')
                ->orderBy(self::tableName() . '.date');

        } elseif ($params['action'] == 'list' && isset($params['city_id']) && $params['city_id'] == 0) {
            $query->select([
                self::tableName() . '.product_id',
                'count(' . self::tableName() . '.product_id) as count',
                'sum(' . self::tableName() . '.views) as views'
            ]);
            $query->groupBy(self::tableName() . '.product_id');
        }

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        });

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
