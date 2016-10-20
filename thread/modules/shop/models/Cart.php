<?php

namespace thread\modules\shop\models;

use Yii;

use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;

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
            [['user_id', 'items_count', 'items_total_count',  'created_at', 'updated_at'], 'integer'],
            [['items_summ', 'items_total_summ', 'discount_percent', 'discount_money', 'discount_full','total_summ'], 'double'],
            [['items_summ', 'items_total_summ', 'discount_percent', 'discount_money', 'discount_full','total_summ'], 'default', 'value' => 0.0],
            [['items_total_count', 'items_count'], 'default', 'value' => 0],
            [['user_id'], 'default', 'value' => 0],
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
            'backend' => ['items_summ', 'items_total_summ', 'discount_percent', 'discount_money', 'discount_full','total_summ','user_id', 'items_count', 'items_total_count',  'created_at', 'updated_at', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'user_id'),
            'php_session_id' => Yii::t('app', 'php_session_id'),
            'items_count' => Yii::t('app', 'count of items'),
            'items_total_count' => Yii::t('app', 'summ of item_count'),
            'items_summ' => Yii::t('app', 'Summ of items without discount for item'),
            'items_total_summ' => Yii::t('app', 'Total Summ of items with discount for item'),
            'discount_percent' => Yii::t('app', 'Percent discount for order'),
            'discount_money' => Yii::t('app', 'Discount of money for order'),
            'discount_full' => Yii::t('app', 'Summ discount for order'),
            'total_summ' => Yii::t('app', 'Finish Summ'),
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
        return $this->hasOne(CartItem::class, ['cart_id' => 'id']);
    }

    
}