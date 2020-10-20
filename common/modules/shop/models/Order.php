<?php

namespace common\modules\shop\models;

use voskobovich\behaviors\ManyToManyBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use common\modules\location\models\{
    City, Country
};
use common\modules\user\models\User;

/**
 * Class Order
 *
 * @property integer $id
 * @property string $product_type
 * @property string $lang
 * @property integer $customer_id
 * @property integer $country_id
 * @property integer $city_id
 * @property string $order_status
 * @property integer $items_count
 * @property integer $items_total_count
 * @property string $comment
 * @property string $image_link
 * @property string $admin_comment
 * @property string $token
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 * @property integer $create_campaign
 * @property integer $mark
 * @property integer $mark1
 *
 * @property boolean $isArchive
 * @property OrderAnswer[] $orderAnswers
 * @property OrderAnswer $orderAnswer
 * @property OrderItem[] $items
 * @property Customer $customer
 * @property City $city
 * @property Country $country
 * @property OrderRelUserForAnswer $orderRelUserForAnswer
 *
 * @package common\modules\shop\models
 */
class Order extends \thread\modules\shop\models\Order
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'user_for_answer_ids' => 'orderRelUserForAnswer',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['customer_id', 'country_id'], 'required', 'on' => ['backend', 'addNewOrder']],
            [['comment', 'admin_comment'], 'string', 'max' => 512],
            [['token'], 'string', 'max' => 255],
            [['customer_id', 'country_id', 'city_id', 'items_count', 'items_total_count'], 'integer'],
            [['order_status'], 'in', 'range' => array_keys(self::getOrderStatuses())],
            [['product_type'], 'in', 'range' => array_keys(self::productTypeKeyRange())],
            [
                ['published', 'deleted', 'create_campaign', 'mark', 'mark1'],
                'in',
                'range' => array_keys(self::statusKeyRange())
            ],
            [['image_link'], 'string', 'max' => 255],
            // set default values
            [['delivery_method_id', 'payment_method_id', 'country_id', 'city_id'], 'default', 'value' => 0],
            [
                [
                    'user_for_answer_ids',
                ],
                'each',
                'rule' => ['integer']
            ],
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
            'mark' => ['mark'],
            'mark1' => ['mark1'],
            'admin_comment' => ['admin_comment'],
            'backend' => [
                'customer_id',
                'country_id',
                'city_id',
                'delivery_method_id',
                'payment_method_id',
                'items_count',
                'items_total_count',
                'order_status',
                'comment',
                'image_link',
                'admin_comment',
                'token',
                'published',
                'deleted',
                'create_campaign',
                'created_at',
                'updated_at',
                'user_for_answer_ids'
            ],
            'addNewOrder' => [
                'product_type',
                'lang',
                'delivery_method_id',
                'payment_method_id',
                'order_status',
                'comment',
                'image_link',
                'customer_id',
                'country_id',
                'city_id',
                'items_count',
                'items_total_count',
                'token',
                'published',
                'deleted'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'lang' => Yii::t('app', 'lang'),
            'comment' => Yii::t('app', 'Comment client'),
            'admin_comment' => Yii::t('app', 'Admin comment'),
            'image_link' => Yii::t('app', 'Image link'),
            'user_for_answer_ids' => 'Партнеры, которые могут отвечать на архивные заявки'
        ];

        return ArrayHelper::merge(parent::attributeLabels(), $attributeLabels);
    }

    /**
     * @return array
     */
    public static function productTypeKeyRange()
    {
        return [
            'product' => 'product',
            'sale-italy' => 'sale-italy',
        ];
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
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return mixed|\yii\db\ActiveQuery
     * @throws \Throwable
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
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

    /**
     * @return bool
     */
    public function isArchive()
    {
        $isArchive = false;

        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->profile->partner_in_city &&
            in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->city_id == $this->city_id) {
            $isArchive = false;
        } elseif ($this->orderRelUserForAnswer) {
            foreach ($this->orderRelUserForAnswer as $user) {
                if ($user->id == Yii::$app->user->identity->id) {
                    $isArchive = false;
                }
            }
        } elseif (date_diff(new \DateTime(), new \DateTime(date(DATE_ATOM, $this->created_at)))->days >= 5) {
            $isArchive = true;
        } elseif (count($this->orderAnswers) >= 3) {
            $isArchive = true;
        }

        return $isArchive;
    }

    /**
     * @return string
     */
    public function getOrderStatus()
    {
        return ($this->isArchive())
            ? Yii::t('app', 'Archival')
            : Yii::t('app', 'New');
    }

    /**
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var Shop $module */
        $module = Yii::$app->getModule('shop');

        $path = $module->getOrderUploadPath();
        $url = $module->getOrderUploadUrl();

        $image = null;
        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }
        return $image;
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getOrderRelUserForAnswer()
    {
        return $this
            ->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable(OrderRelUserForAnswer::tableName(), ['order_id' => 'id']);
    }
}
