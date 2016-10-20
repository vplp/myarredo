<?php

namespace thread\modules\shop\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class DeliveryMethods
 *
 * @package thread\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class DeliveryMethods extends \thread\models\ActiveRecord {

    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\shop\Shop::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%shop_delivery_methods}}';
    }

    /**
     *
     * @return array
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
            'transliterate' => [
                'class' => TransliterateBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['alias' => 'alias'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['alias' => 'alias']
                ]
            ],
        ]);
    }

    /**
     *
     * @return array
     */
    public function rules() {
        return [
            [['create_time', 'update_time', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios() {
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
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'position' => Yii::t('app', 'position'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(DeliveryMethodsLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return ActiveQuery
     */
    public static function find_base() {
        return self::find()->with(['lang'])->undeleted();
    }

    /**
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        return (new search\DeliveryMethods)->search($params);
    }

    /**
     *
     * @return array|null
     */
    public static function all() {
        return self::find_base()->all();
    }

}
