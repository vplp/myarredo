<?php

namespace api\modules\shop\models\search;

use api\modules\shop\models\Order;
use backend\modules\catalog\models\Flower;
use common\modules\user\models\ClientsManager;
use thread\modules\user\models\Group;
use Yii;
use backend\modules\shop\models\search\OrderItem as BackendModel;
use \api\modules\shop\models\OrderItem as ApiModel;
use yii\data\ActiveDataProvider;


class OrderItem extends BackendModel
{
    public function baseSearch($query, $params)
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 100000000
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC
                    ]
                ]
            ]
        );

//        if (!($this->load($params) && $this->validate())) {
//            return $dataProvider;
//        }

//        $query->andFilterWhere(['plantation_id' => $this->plantation_id]);
//        $query->andFilterWhere(['order_id' => $this->order_id]);
//        $query->andFilterWhere(['>=', Order::tableName() . '.desired_delivery_date', $this->from_desired_delivery_date]);
//        $query->andFilterWhere(['<=', Order::tableName() . '.desired_delivery_date', $this->to_desired_delivery_date]);
//        $query->andFilterWhere([
//            Flower::tableName() . '.type_id' => $this->type_id,
//            Flower::tableName() . '.size_id' => $this->size_id,
//            Flower::tableName() . '.color_id' => $this->color_id,
//            Flower::tableName() . '.sort_id' => $this->sort_id
//        ]);

        /**
         * выборка заказов только тех клиентов которых отслеживает менеджер
         * АДМИНУ показываем все позиции
         */
        $userIdentity = Yii::$app->user->identity;
        if (!is_null($userIdentity) && isset($userIdentity->group_id) && $userIdentity->group_id == Group::MANAGER) {
            $users = ClientsManager::getUserIdByManagerId($userIdentity->id);
            $query->filterWhere([Order::tableName() . '.user_id' => $users]);
        }

        return $dataProvider;
    }

    public function search($params)
    {
        $query = ApiModel::find()
            ->innerJoinWith(['order'])
            ->andWhere([Order::tableName() . '.type_order' => Order::$type_order])
            ->andWhere([Order::tableName() . '.status' => Order::getOrderStatusForApi()])
            ->innerJoinWith(['flower']);
        return $this->baseSearch($query, $params);
    }

}