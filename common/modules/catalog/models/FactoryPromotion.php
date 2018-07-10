<?php

namespace common\modules\catalog\models;

use Yii;
use yii\helpers\{
    ArrayHelper
};
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class FactoryPromotion
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $count_of_months
 * @property double $daily_budget
 * @property double $cost
 * @property boolean $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 *
 * @property TypesLang $lang
 *
 * @package common\modules\catalog\models
 */
class FactoryPromotion extends ActiveRecord
{
    /**
     * @return string
     */
    public static function getDb()
    {
        return Catalog::getDb();
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_factory_promotion}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), []);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'count_of_months', 'daily_budget', 'created_at', 'updated_at', 'position'], 'integer'],
            [['cost'], 'double'],
            [['status', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'position' => ['position'],
            'backend' => [
                'user_id',
                'count_of_months',
                'daily_budget',
                'cost',
                'status',
                'published',
                'deleted'
            ],
            'frontend' => [
                'user_id',
                'count_of_months',
                'daily_budget',
                'cost',
                'status',
                'published',
                'deleted'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'count_of_months' => 'Кол-во месяцев',
            'daily_budget' => 'Дневной бюджет',
            'cost' => 'Стоимость',
            'status' => 'Статус',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
            'published' => Yii::t('app', 'Published'),
            'deleted' => Yii::t('app', 'Deleted')
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (Yii::$app->user->identity->group->role == 'factory') {
            $this->user_id = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find();
    }

    /**
     * @return array
     */
    public static function getCountOfMonthsRange()
    {
        return [
            1 => '1 мес',
            2 => '2 мес',
            3 => '3 мес',
            4 => '4 мес',
            5 => '5 мес',
        ];
    }

    /**
     * @return array
     */
    public static function getDailyBudgetRange()
    {
        return [
            500 => '500 руб/мес',
            800 => '800 руб/мес',
            1000 => '1000 руб/мес',
            1500 => '1500 руб/мес',
            2000 => '2000 руб/мес',
        ];
    }
}