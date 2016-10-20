<?php

namespace thread\modules\shop\models;

use Yii;

use thread\app\base\models\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

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
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'position' => Yii::t('app', 'position'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
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
