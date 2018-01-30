<?php

namespace common\modules\shop\models;


use common\modules\location\models\CityLang;
use Yii;
use yii\helpers\ArrayHelper;
//
use common\modules\location\models\City;

/**
 * Class Order
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $city_id
 * @property string $order_status
 * @property integer $items_count
 * @property integer $items_total_count
 * @property string $comment
 * @property string $token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $create_campaign
 *
 * @property boolean $isArchive
 * @property OrderAnswer[] $orderAnswers
 * @property OrderAnswer[] $orderAnswer
 * @property OrderItem[] $items
 * @property Customer[] $customer
 * @property City[] $city
 *
 * @package common\modules\shop\models
 */
class Order extends \thread\modules\shop\models\Order
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['customer_id', 'city_id'], 'required'],
            [['comment'], 'string', 'max' => 512],
            [['token'], 'string', 'max' => 255],
            [['customer_id', 'city_id', 'items_count', 'items_total_count'], 'integer'],
            [['order_status'], 'in', 'range' => array_keys(self::getOrderStatuses())],
            [['published', 'deleted', 'create_campaign'], 'in', 'range' => array_keys(self::statusKeyRange())],

            // set default values
            [['delivery_method_id', 'payment_method_id'], 'default', 'value' => 0]
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'create_campaign' => ['create_campaign'],
            'backend' => [
                'customer_id',
                'city_id',
                'delivery_method_id', 'payment_method_id',
                'items_count',
                'items_total_count',
                'order_status',
                'comment',
                'token',
                'published',
                'deleted',
                'create_campaign',
                'created_at',
                'updated_at'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'comment' => Yii::t('app', 'Comment client'),
        ];

        return ArrayHelper::merge(parent::attributeLabels(), $attributeLabels);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['items'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this
            ->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this
            ->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this
            ->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getOrderAnswers()
    {
        return $this
            ->hasMany(OrderAnswer::class, ['order_id' => 'id'])
            ->andWhere(OrderAnswer::tableName() . '.answer_time > 0');
    }

    /**
     * @return mixed
     */
    public function getOrderAnswer()
    {
        $modelAnswer = OrderAnswer::findByOrderIdUserId(
            $this->id,
            Yii::$app->getUser()->getId()
        );

        if ($modelAnswer == null) {
            $modelAnswer = new OrderAnswer();
        }

        return $modelAnswer;
    }

    public function isArchive()
    {
        return (count($this->orderAnswers) >= 3) ? true : false;
    }

    public function getOrderStatus()
    {
        return ($this->isArchive())
            ? Yii::t('app', 'Archival')
            : Yii::t('app', 'New');
    }
}