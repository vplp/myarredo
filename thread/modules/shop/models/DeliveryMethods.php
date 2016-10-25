<?php

namespace thread\modules\shop\models;

use Yii;
use yii\behaviors\AttributeBehavior;

use yii\helpers\{
    ArrayHelper, Inflector
};

use thread\modules\shop\Shop;
use thread\app\base\models\ActiveRecord;


/**
 * Class DeliveryMethods
 *
 * @package thread\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class DeliveryMethods extends ActiveRecord
{

    /**
     * @return string
     */
    public static function getDb()
    {
        return Shop::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%shop_delivery_methods}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'alias',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'alias',
                ],
                'value' => function ($event) {
                    return Inflector::slug($this->alias);
                },
            ],
        ]);
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['created_at', 'updated_at', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['position', 'alias', 'published', 'deleted'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'alias' => Yii::t('app', 'Alias'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(DeliveryMethodsLang::class, ['rid' => 'id']);
    }


}
