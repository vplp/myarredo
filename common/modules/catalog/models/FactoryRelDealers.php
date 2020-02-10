<?php

namespace common\modules\catalog\models;

use thread\app\base\models\ActiveRecord;
//
use common\modules\user\User;
use common\modules\catalog\Catalog;

/**
 * Class FactoryRelDealers
 *
 * @property string $factory_id
 * @property string $dealer_id
 *
 * @package common\modules\catalog\models
 */
class FactoryRelDealers extends ActiveRecord
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
        return '{{%catalog_factory_rel_dealers}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['factory_id', 'exist', 'targetClass' => Factory::class, 'targetAttribute' => 'id'],
            ['dealer_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => [
                'factory_id',
                'dealer_id',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'factory_id',
            'dealer_id',
        ];
    }
}
