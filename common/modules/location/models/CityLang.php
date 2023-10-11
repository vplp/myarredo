<?php

namespace common\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class CityLang
 *
 * @property string $title
 * @property string $title_where
 *
 * @package common\modules\location\models
 */
class CityLang extends \thread\modules\location\models\CityLang
{
    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            ['title_where', 'string', 'max' => 128]
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
                'title_where'
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
            'title_where' => Yii::t('app', 'Title where'),
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }
}
