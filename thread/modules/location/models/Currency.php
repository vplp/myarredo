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
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Currency extends ActiveRecord
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
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_currency}}';
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
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['alias', 'code1', 'course', 'code2', 'published', 'currency_symbol', 'deleted'],
        ];
    }

    /**
     *
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
