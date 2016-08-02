<?php

namespace thread\modules\location\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\{
    ArrayHelper, Inflector
};
//
use thread\app\base\models\ActiveRecord;
use thread\modules\location\Location as LocationModule;

/**
 * Class Country
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Country extends ActiveRecord
{

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return LocationModule::getDb();
    }

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_country}}';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
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
            ]
        );
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [
                [
                    'created_at',
                    'on_main',
                    'view_for_sanatorium',
                    'position',
                    'updated_at',
                    'iso',
                    'visa',
                    'visa_supply'
                ],
                'integer'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['position'], 'default', 'value' => 0],
            [['alias'], 'string', 'max' => 128],
            [['alpha2'], 'string', 'min' => 2, 'max' => 2],
            [['alpha3'], 'string', 'min' => 3, 'max' => 3],
            [['alias'], 'unique'],
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
            'backend' => [
                'alias',
                'alpha2',
                'alpha3',
                'iso',
                'published',
                'deleted',
            ],
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
            'alpha2' => Yii::t('app', 'alpha2'),
            'alpha3' => Yii::t('app', 'alpha3'),
            'iso' => Yii::t('app', 'iso'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CountryLang::class, ['rid' => 'id']);
    }

}
