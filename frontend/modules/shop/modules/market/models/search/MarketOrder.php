<?php

namespace frontend\modules\shop\modules\market\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\shop\modules\market\models\{
    MarketOrder as ParentModel, MarketOrderRelPartner
};

/**
 * Class MarketOrder
 *
 * @package frontend\modules\shop\models\search
 */
class MarketOrder extends ParentModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'city_id'], 'integer'],
            [['email', 'full_name'], 'string', 'max' => 50],
        ];
    }

    /**
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
     */
    public function baseSearch($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 100,
                'forcePageParam' => false,
            ],
        ]);

        if (in_array(Yii::$app->user->identity->group->role, ['partner'])) {
            $query
                ->innerJoinWith(['partners'], false)
                ->andFilterWhere(['IN', MarketOrderRelPartner::tableName() . '.user_id', Yii::$app->user->id]);
        }

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id
        ]);

        if (empty($countries) && isset($params['country_id']) && $params['country_id'] > 0) {
            $query->andFilterWhere([self::tableName() . '.country_id' => $params['country_id']]);
        }

        if (isset($params['city_id']) && $params['city_id'] > 0) {
            $query->andFilterWhere([self::tableName() . '.city_id' => $params['city_id']]);
        }

        if (isset($params['full_name'])) {
            $query->andFilterWhere(['like', self::tableName() . '.full_name', $params['full_name']]);
        }

        if (isset($params['email'])) {
            $query->andFilterWhere(['like', self::tableName() . '.email', $params['email']]);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = ParentModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
