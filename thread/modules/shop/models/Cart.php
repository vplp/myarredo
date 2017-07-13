<?php

namespace thread\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;
use thread\modules\shop\models\query\CartQuery;

/**
 * Class Cart
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $php_session_id
 * @property integer $items_count
 * @property integer $items_total_count
 * @property float $items_summ
 * @property float $items_total_summ
 * @property float $discount_percent
 * @property float $discount_money
 * @property float $discount_full
 * @property float $total_summ
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $published
 * @property integer $deleted
 *
 * @property CartItem[] $items
 *
 * @package thread\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Cart extends ActiveRecord
{
    /**
     * @var
     */
    public static $commonQuery = CartQuery::class;

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
        return '{{%shop_cart}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['phpsessid'], 'required'],
            [['phpsessid'], 'string', 'max' => 30],
            [['user_id', 'items_count', 'items_total_count', 'created_at', 'updated_at'], 'integer'],
            [
                ['items_summ', 'items_total_summ', 'discount_percent', 'discount_money', 'discount_full', 'total_summ'],
                'double'
            ],
            [['items_total_count', 'items_count'], 'default', 'value' => 0],
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
                'items_summ',
                'items_total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'total_summ',
                'user_id',
                'items_count',
                'items_total_count',
                'published',
                'deleted'
            ],
            'addcart' => [
                'items_summ',
                'items_total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'total_summ',
                'user_id',
                'items_count',
                'items_total_count',
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
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('shop', 'User id'),
            'php_session_id' => Yii::t('shop', 'php_session_id'),
            'items_count' => Yii::t('shop', 'Count of items'),
            'items_total_count' => Yii::t('shop', 'Summ of item_count'),
            'items_summ' => Yii::t('shop', 'Summ of items without discount for item'),
            'items_total_summ' => Yii::t('shop', 'Total Summ of items with discount for item'),
            'discount_percent' => Yii::t('shop', 'Percent discount for order'),
            'discount_money' => Yii::t('shop', 'Discount of money for order'),
            'discount_full' => Yii::t('shop', 'Summ discount for order'),
            'total_summ' => Yii::t('shop', 'Finish Summ'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }

    /**
     *
     * @return string
     */
    public static function getSessionID()
    {
        return isset($_COOKIE['PHPSESSID']) ? $_COOKIE['PHPSESSID'] : '';
    }


    public static function findBySessionID()
    {
        return self::find()->php_session_id(self::getSessionID())->enabled()->one();
    }

    /**
     *
     * @return $this
     */
    public function recalculate()
    {

        $this->items_summ = 0;
        $this->items_total_summ = 0;
        $this->total_summ = 0;
        $this->items_total_count = 0;
        $this->items_count = count($this->items);

        foreach ($this->items as $item) {
            $this->items_total_count += $item->count;
            $this->items_summ += $item->summ;
            $this->items_total_summ += $item->total_summ;
        }
        $this->total_summ = $this->items_total_summ - $this->discount_full;

    }


}