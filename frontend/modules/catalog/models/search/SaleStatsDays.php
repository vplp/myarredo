<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{
    SaleStatsDays as SaleStatsModel
};

/**
 * Class SaleStatsDays
 *
 * @package frontend\modules\catalog\models\search
 */
class SaleStatsDays extends SaleStatsModel
{
    public $start_date;
    public $end_date;
    public $type;

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
            'pagination' => ($params['action'] == 'view')
                ? false
                : [
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

        if ($params['action'] == 'view') {
            $query->select([
                self::tableName() . '.product_id',
                self::tableName() . '.date',
                'count(' . self::tableName() . '.date) as count',
                'sum(' . self::tableName() . '.views) as views',
                'sum(' . self::tableName() . '.requests) as requests'
            ]);
            $query->groupBy(self::tableName() . '.date')->orderBy(self::tableName() . '.date');
        } elseif ($params['action'] == 'list') {
            $query->select([
                self::tableName() . '.product_id',
                'count(' . self::tableName() . '.product_id) as count',
                'sum(' . self::tableName() . '.views) as views',
                'sum(' . self::tableName() . '.requests) as requests'
            ]);
            $query->groupBy(self::tableName() . '.product_id');
        }

        if (isset($params['type']) && in_array($params['type'], ['views', 'requests'])) {
            $query->orderBy($params['type'] . ' DESC');
        } elseif (Yii::$app->controller->action->id != 'view') {
            $query->orderBy(['views' => SORT_DESC]);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     */
    public function search($params)
    {
        $query = SaleStatsModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseFactorySearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ($params['action'] == 'view')
                ? false
                : [
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

        if ($params['action'] == 'view') {
            $query->select([
                self::tableName() . '.factory_id',
                self::tableName() . '.date',
                'count(' . self::tableName() . '.date) as count',
                'sum(' . self::tableName() . '.views) as views',
                'sum(' . self::tableName() . '.requests) as requests'
            ]);
            $query->groupBy(self::tableName() . '.date')
                ->orderBy(self::tableName() . '.date');

        } elseif ($params['action'] == 'list') {
            $query->select([
                self::tableName() . '.factory_id',
                'count(' . self::tableName() . '.factory_id) as count',
                'sum(' . self::tableName() . '.views) as views',
                'sum(' . self::tableName() . '.requests) as requests'
            ]);
            $query->groupBy(self::tableName() . '.factory_id');
        }

        if (isset($params['type']) && in_array($params['type'], ['views', 'requests'])) {
            $query->orderBy($params['type'] . ' DESC');
        } elseif (Yii::$app->controller->action->id != 'view') {
            $query->orderBy(['views' => SORT_DESC]);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function factorySearch($params)
    {
        $query = SaleStatsModel::findBase();
        return $this->baseFactorySearch($query, $params);
    }
}
