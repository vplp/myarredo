<?php

namespace thread\modules\location\models;

use thread\app\base\models\ActiveRecord;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;


/**
 * Class Currency
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Currency extends ActiveRecord
{

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\location\Location::getDb();
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
            [['alias'], 'required'],
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
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'code1' => Yii::t('app', 'code1'),
            'code2' => Yii::t('app', 'code2'),
            'created_at' => Yii::t('app', 'created_at'),
            'updated_at' => Yii::t('app', 'updated_at'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'course' => Yii::t('app', 'course'),
            'currency_symbol' => Yii::t('app', '(Html code) to display a currency symbol'),
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CurrencyLang::class, ['rid' => 'id']);
    }

    /**
     * The Base method for query construction of the method find
     * @return yii\db\ActiveQuery
     */
    public static function find_base()
    {
        return self::find()->enabled();
    }

}
