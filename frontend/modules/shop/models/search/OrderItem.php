<?php

namespace frontend\modules\shop\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\base\Exception;
use yii\log\Logger;
//
use frontend\modules\shop\Shop;
use frontend\modules\shop\models\{CartCustomerForm, OrderAnswer, OrderItem as OrderItemModel, Order, Customer};
use frontend\modules\catalog\models\ItalianProduct;

/**
 * Class OrderItem
 *
 * @package frontend\modules\shop\models\search
 */
class OrderItem extends OrderItemModel
{
    public $product_type;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['product_type'], 'in', 'range' => array_keys(Order::productTypeKeyRange())],
            [['id', 'order_id'], 'integer'],
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

        $query
            ->andFilterWhere([
                'id' => $this->id,
                self::tableName() . '.order_id' => $this->order_id
            ]);

        if (isset($params['product_type'])) {
            $query->andFilterWhere([Order::tableName() . '.product_type' => $params['product_type']]);
        }

        if (isset($params['user_id'])) {
            $query
                ->innerJoinWith(['order.orderAnswers'])
                ->andFilterWhere([OrderAnswer::tableName() . '.user_id' => $params['user_id']]);
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
        $query = OrderItemModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
