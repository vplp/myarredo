<?php

namespace common\modules\seo\modules\directlink\models;

use Yii;
use yii\helpers\ArrayHelper;
use voskobovich\behaviors\ManyToManyBehavior;
use common\modules\location\models\City;

/**
 * Class Directlink
 *
 * @property string $h1
 * @property string $contacts
 *
 * @package common\modules\seo\modules\directlink\models
 */
class Directlink extends \thread\modules\seo\modules\directlink\models\Directlink
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'city_ids' => 'cities',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['content'], 'string'],
            [['h1'], 'string', 'max' => 255],
            [['description', 'keywords', 'image_url', 'h1', 'content'], 'default', 'value' => ''],
            [
                [
                    'city_ids',
                ],
                'each',
                'rule' => ['integer']
            ],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'backend' => ['h1', 'content', 'city_ids'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'h1' => 'H1',
            'content' => Yii::t('app', 'Content'),
            'city_ids' => Yii::t('app', 'Cities'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'location_city_id'])
            ->viaTable('fv_seo_direct_link_rel_location_city', ['seo_direct_link_id' => 'id']);
    }
}
