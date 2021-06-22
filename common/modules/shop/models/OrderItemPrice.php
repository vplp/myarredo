<?php

namespace common\modules\shop\models;

use Yii;
use thread\app\base\models\ActiveRecord;
use common\modules\shop\Shop;
use common\modules\user\models\User;

/**
 * Class OrderItemPrice
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $product_id
 * @property float $price
 * @property string $currency
 * @property integer $out_of_production
 *
 * @package common\modules\shop\models
 */
class OrderItemPrice extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Shop::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%shop_order_item_price}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'product_id'], 'required'],
            [['order_id', 'user_id', 'product_id'], 'integer'],
            [['price'], 'double'],
            [['out_of_production'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [
                ['price'],
                'required',
                'when' => function ($model) {
                    return $model->out_of_production === 0;
                },
                'whenClient' => "function (attribute, value) {
                    var product_id = $('#orderitemprice-product_id').val();
                    return $('input[name=\"OrderItemPrice['+product_id+'][out_of_production]\"]').val() == 0;
                }"
            ],
            [['price'], 'default', 'value' => 0],
            [['currency'], 'in', 'range' => array_keys(static::currencyRange())],
            [['currency'], 'default', 'value' => 'EUR'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'out_of_production' => ['out_of_production'],
            'backend' => [
                'order_id',
                'user_id',
                'product_id',
                'price',
                'currency',
                'out_of_production'
            ],
            'frontend' => [
                'order_id',
                'user_id',
                'product_id',
                'price',
                'currency',
                'out_of_production'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order id'),
            'user_id' => Yii::t('app', 'User'),
            'product_id' => Yii::t('app', 'Product id'),
            'price' => Yii::t('app', 'Price'),
            'currency' => Yii::t('app', 'Currency'),
            'out_of_production' => Yii::t('app', 'Снят с производства'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }

    /**
     * @param $order_id
     * @param $user_id
     * @param $product_id
     * @return mixed
     */
    public static function findByOrderIdUserIdProductId($order_id, $user_id, $product_id)
    {
        return self::findBase()
            ->andWhere([
                self::tableName() . '.order_id' => $order_id,
                self::tableName() . '.user_id' => $user_id,
                self::tableName() . '.product_id' => $product_id
            ])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return array
     */
    public static function currencyRange()
    {
        return [
            'EUR' => 'EUR',
            'RUB' => 'RUB',
            'USD' => 'USD'
        ];
    }

    /**
     * @return mixed
     */
    public function getOrderAnswer()
    {
        $modelAnswer = OrderAnswer::findByOrderIdUserId(
            $this->order_id,
            $this->user_id,
        );

        if ($modelAnswer == null) {
            $modelAnswer = new OrderAnswer();
        }

        return $modelAnswer;
    }
}
