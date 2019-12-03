<?php

namespace common\modules\catalog\models;

use Yii;
//
use thread\app\base\models\ActiveRecord;
//
use common\modules\catalog\Catalog;

/**
 * Class FactoryFileClickStats
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $factory_file_id
 * @property integer $views
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @package common\modules\catalog\models
 */
class FactoryFileClickStats extends ActiveRecord
{
    /**
     * @return object|string|\yii\db\Connection|null
     * @throws \yii\base\InvalidConfigException
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
        return '{{%catalog_factory_file_click_stats}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'user_id',
                    'factory_file_id',
                    'views',
                    'create_time',
                    'update_time',
                ],
                'integer'
            ],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'setMark' => ['mark'],
            'frontend' => [
                'user_id',
                'factory_file_id',
                'views',
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
            'factory_file_id',
            'views',
            'created_at' => Yii::t('app', 'Create time'),
            'updated_at' => Yii::t('app', 'Update time'),
        ];
    }
}
