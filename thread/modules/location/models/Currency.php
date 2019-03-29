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
 * Class Currency
 *
 * @property int $id
 * @property string $alias
 * @property string $code1
 * @property string $code2
 * @property string $title
 * @property float $course
 * @property string $currency_symbol
 * @property int $created_at
 * @property int $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @package thread\modules\location\models
 */
class Currency extends ActiveRecord
{
    /**
     * @return object|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
        return '{{%location_currency}}';
    }

    /**
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
            [['alias', 'code1', 'code2'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['code1', 'code2'], 'string', 'max' => 4],
            [['alias'], 'string', 'max' => 255],
            [['currency_symbol'], 'string', 'max' => 100],
            [['course'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['alias'], 'unique']
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
            'setCourse' => ['course'],
            'backend' => ['alias', 'code1', 'course', 'code2', 'published', 'currency_symbol', 'deleted'],
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
            'code1' => Yii::t('location', 'code1'),
            'code2' => Yii::t('location', 'code2'),
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted'),
            'course' => Yii::t('location', 'Course'),
            'currency_symbol' => Yii::t('location', '(Html code) to display symbol'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CurrencyLang::class, ['rid' => 'id']);
    }
}
