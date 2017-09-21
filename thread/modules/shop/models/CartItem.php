<?php

namespace thread\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;
use thread\modules\shop\models\query\CartItemQuery;

/**
 * Class CartItem
 *
 * @property integer $id
 * @property integer $cart_id
 * @property integer $product_id
 * @property integer $count
 * @property float $price
 * @property float $discount_percent
 * @property float $discount_money
 * @property float $discount_full
 * @property float $summ
 * @property float $total_summ
 * @property string $extra_param
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @package thread\modules\shop\models
 */
class CartItem extends ActiveRecord
{
    /**
     * @var string
     */
    public static $commonQuery = CartItemQuery::class;

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
        return '{{%shop_cart_item}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['cart_id', 'product_id'], 'required'],
            [['cart_id', 'product_id', 'count', 'created_at', 'updated_at'], 'integer'],
            [['price', 'summ', 'total_summ', 'discount_percent', 'discount_money', 'discount_full'], 'double'],
            [
                ['price', 'summ', 'total_summ', 'discount_percent', 'discount_money', 'discount_full'],
                'default',
                'value' => 0.0
            ],
            [['extra_param'], 'string'],
            [['count'], 'default', 'value' => 1],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
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
            'backend' => [
                'cart_id',
                'product_id',
                'summ',
                'total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'extra_param',
                'count',
                'published',
                'deleted'
            ],
            'addCartItem' => [
                'cart_id',
                'product_id',
                'summ',
                'total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'extra_param',
                'count'
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
            'cart_id' => Yii::t('shop', 'Cart'),
            'product_id' => Yii::t('shop', 'Product'),
            'count' => Yii::t('shop', 'Count of item'),
            'summ' => Yii::t('shop', 'Summ without discount for item'),
            'total_summ' => Yii::t('shop', 'Total Summ with discount for item'),
            'discount_percent' => Yii::t('shop', 'Percent discount for order'),
            'discount_money' => Yii::t('shop', 'Discount of money for order'),
            'discount_full' => Yii::t('shop', 'Summ discount for order'),
            'extra_param' => Yii::t('shop', 'Extra param'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @param $cart_id
     * @param $product_id
     * @return mixed
     */
    public static function findByProductID($cart_id, $product_id)
    {
        return self::find()->cart_id($cart_id)->product_id($product_id)->enabled()->one();
    }

    /**
     * @return $this
     */
    public function recalculate()
    {
        $this->summ = $this->count * $this->price;
        $this->total_summ = $this->summ - $this->discount_full;

        return $this;
    }

    /**
     * @param $cart_id
     * @return mixed
     */
    public static function findAllByCartID($cart_id)
    {
        return self::find()->cart_id($cart_id)->addOrderBy('created_at DESC')->all();
    }
}