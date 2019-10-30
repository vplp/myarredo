<?php

namespace frontend\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\shop\Shop;
use frontend\modules\shop\models\{
    OrderAnswer as OrderAnswerModel
};

/**
 * Class OrderAnswer
 *
 * @package frontend\modules\shop\models\search
 */
class OrderAnswer extends OrderAnswerModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
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
        /** @var Shop $module */
        $module = Yii::$app->getModule('shop');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => isset($params['defaultPageSize']) ? $params['defaultPageSize'] : $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        if (isset($params['user_id'])) {
            $query
                ->andFilterWhere([self::tableName() . '.user_id' => $params['user_id']]);
        }

        $query->orderBy(self::tableName() . '.answer_time DESC');

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = OrderAnswerModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
