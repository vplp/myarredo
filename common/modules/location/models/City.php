<?php

namespace common\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class City
 *
 * @package common\modules\location\models
 */
class City extends \thread\modules\location\models\City
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['lat', 'lng'], 'double'],
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            'backend' => [
                'lat', 'lng'
            ]
        ];

        return ArrayHelper::merge($scenarios, parent::scenarios());
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'lat' => Yii::t('app', 'Latitude'),
            'lng' => Yii::t('app', 'Longitude'),
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }
}
