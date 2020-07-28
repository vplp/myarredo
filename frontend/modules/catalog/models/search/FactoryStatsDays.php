<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{
    FactoryStatsDays as FactoryStatsDaysModel
};

/**
 * Class FactoryStatsDays
 *
 * @package frontend\modules\catalog\models\search
 */
class FactoryStatsDays extends FactoryStatsDaysModel
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
            [['country_id', 'city_id', 'factory_id'], 'integer'],
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
     * @param $params
     * @return mixed|ActiveDataProvider
     */
    public function search($params)
    {
        $query = FactoryStatsDaysModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var $module Catalog */
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
            $query->andFilterWhere([self::tableName() . '.factory_id' => $params['factory_id']]);
        }

        if (isset($params['start_date']) && $params['start_date'] != '' && isset($params['end_date']) && $params['end_date'] != '') {
            $query->andFilterWhere([
                'between',
                self::tableName() . '.date',
                strtotime($params['start_date'] . ' 0:00'),
                strtotime($params['end_date'] . ' 23:59')
            ]);
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
                //'count(' . self::tableName() . '.date) as count',
                'sum(' . self::tableName() . '.views) as views',
                'sum(' . self::tableName() . '.requests) as requests'
            ]);
            $query->groupBy(self::tableName() . '.date')
                ->orderBy(self::tableName() . '.date');

        } elseif ($params['action'] == 'list') {
            $query->select([
                self::tableName() . '.factory_id',
                //'count(' . self::tableName() . '.factory_id) as count',
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
}
