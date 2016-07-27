<?php

namespace thread\modules\location\models;

use thread\app\base\models\ActiveRecord;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;
use yii\helpers\Inflector;

class City extends ActiveRecord
{

    /**
     * @inheritdoc
     */

    public static function getDb()
    {
        return \thread\modules\location\Location::getDb();
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
            [['location_country_id', 'created_at', 'updated_at'], 'integer'],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'location_country_id' => Yii::t('app', 'Country'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
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
                'location_country_id',
                'created_at',
                'updated_at',
                'published',
                'deleted',
                'search_title'
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
        return $this->hasOne(Country::class, ['id' => 'location_country_id']);
    }

}
