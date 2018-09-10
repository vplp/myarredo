<?php

namespace common\modules\seo\modules\directlink\models;

use Yii;
use yii\helpers\ArrayHelper;
use voskobovich\behaviors\ManyToManyBehavior;
use common\modules\location\models\City;

/**
 * Class Directlink
 *
 * @property Lang $lang
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
        return parent::rules();
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'add_to_sitemap' => ['add_to_sitemap'],
            'dissallow_in_robotstxt' => ['dissallow_in_robotstxt'],
            'backend' => [
                'url',
                'published',
                'deleted',
                'add_to_sitemap',
                'dissallow_in_robotstxt',
                'meta_robots',
                'image_url',
                'city_ids'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'city_ids' => Yii::t('app', 'Cities'),
        ]);
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()->joinWith(['lang']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(DirectlinkLang::class, ['rid' => 'id']);
    }
}
