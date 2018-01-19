<?php

namespace common\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class City
 *
 * @property integer $id
 * @property string $alias
 * @property integer $country_id
 * @property float $lat
 * @property float $lng
 * @property string $geo_placename
 * @property string $geo_position
 * @property string $geo_region
 * @property string $icbm
 * @property integer $created_at
 * @property integer $updated_at
 * @property boolean $published
 * @property boolean $deleted
 * @property integer $position
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
            [['geo_placename', 'geo_position', 'geo_region', 'icbm'], 'string', 'max' => 128]
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
                'lat', 'lng', 'geo_placename', 'geo_position', 'geo_region', 'icbm'
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
            'geo_placename' => 'geo.placename',
            'geo_position'  => 'geo.position',
            'geo_region'  => 'geo.region',
            'icbm'  => 'ICBM',
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->joinWith(['lang'])
            ->orderBy(CityLang::tableName() . '.title');
    }

    /**
     * @param string $alias
     * @return mixed
     */
    public static function findByAlias($alias)
    {
        return self::findBase()->byAlias($alias)->one();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }
}
