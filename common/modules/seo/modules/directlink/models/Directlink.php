<?php

namespace common\modules\seo\modules\directlink\models;

use Yii;
use yii\helpers\ArrayHelper;
use voskobovich\behaviors\ManyToManyBehavior;
use common\modules\location\models\City;

/**
 * Class Directlink
 *
 * @property City[] $cities
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
        return ArrayHelper::merge(parent::scenarios(), [
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
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['backend'])) {
            $this->mark = '0';
        }

        return parent::beforeSave($insert);
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
     * @throws \yii\base\InvalidConfigException
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
