<?php

namespace thread\modules\shop\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\shop\Shop;

/**
 * Class PaymentMethods
 *
 * @package thread\modules\shop\models
 */
class PaymentMethods extends ActiveRecord
{
    /**
     * @return null|object
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
        return '{{%shop_payment_methods}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'position'], 'integer'],
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
            'backend' => ['position', 'published', 'deleted'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(PaymentMethodsLang::class, ['rid' => 'id']);
    }
}