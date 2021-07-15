<?php

namespace thread\modules\location\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
//
use thread\app\base\models\ActiveRecord;
use thread\modules\location\Location as LocationModule;

/**
 * Class City
 *
 * @package thread\modules\location\models
 */
class City extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function getDb()
    {
        return LocationModule::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_city}}';
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
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['country_id', 'created_at', 'updated_at', 'position'], 'integer'],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['position'], 'default', 'value' => 0],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'Alias'),
            'country_id' => Yii::t('location', 'Country'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'position' => Yii::t('app', 'Position'),
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
                'alias',
                'country_id',
                'created_at',
                'updated_at',
                'published',
                'deleted',
                'position'
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CityLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title)) ? $this->lang->title : "{{$this->alias}}";
    }
}
