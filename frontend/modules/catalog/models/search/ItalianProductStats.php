<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{
    ItalianProductStats as ItalianProductStatsModel
};

/**
 * Class ItalianProductStats
 *
 * @package frontend\modules\catalog\models\search
 */
class ItalianProductStats extends ItalianProductStatsModel
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
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
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

        if (!($this->load($params, '') /*&& $this->validate()*/)) {
            return $dataProvider;
        }
        
        if (isset($params['factory_id']) && $params['factory_id'] > 0) {
            $query->andWhere([ItalianProduct::tableName() . '.factory_id' => $params['factory_id']]);
        }

        if (isset($params['country_id']) && $params['country_id'] > 0 && !$params['city_id']) {
            $model = City::findAll(['country_id' => $params['country_id']]);

            if ($model != null) {
                foreach ($model as $city) {
                    $city_id[] = $city['id'];
                }
                $query->andFilterWhere(['IN', self::tableName() . '.city_id', $city_id]);
            }
        } elseif (isset($params['city_id']) && $params['city_id'] > 0) {
            $query->andFilterWhere(['IN', self::tableName() . '.city_id', $params['city_id']]);
        }

        if (isset($params['start_date']) && $params['start_date'] != '' && isset($params['end_date']) && $params['end_date'] != '') {
            $query->andWhere(['>=', self::tableName() . '.created_at', strtotime($params['start_date'] . ' 0:00')]);
            $query->andWhere(['<=', self::tableName() . '.created_at', strtotime($params['end_date'] . ' 23:59')]);
        }

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 60 * 60 * 3, self::generateDependency(self::find()));

        return $dataProvider;
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = ItalianProductStatsModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
