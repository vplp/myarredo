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
 * @property integer $show_price
 * @property integer $jivosite
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
            [['geo_placename', 'geo_position', 'geo_region', 'icbm'], 'string', 'max' => 128],
            [['show_price'], 'in', 'range' => array_keys(static::statusKeyRange())],
            ['jivosite', 'string', 'max' => 255]
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            'show_price' => ['show_price'],
            'backend' => [
                'lat', 'lng', 'geo_placename', 'geo_position', 'geo_region', 'icbm', 'show_price', 'jivosite'
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
            'geo_position' => 'geo.position',
            'geo_region' => 'geo.region',
            'icbm' => 'ICBM',
            'show_price' => Yii::t('app', 'Show price'),
            'jivosite' => 'Чат jivosite src'
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (isset($this->lang->title)) ? $this->lang->title : "{{$this->alias}}";
    }

    /**
     * @return mixed
     */
    public static function findBase()
    {
        $order[] = self::tableName() . '.`id` = 4 DESC';
        $order[] = self::tableName() . '.`id` = 5 DESC';
        $order[] = CityLang::tableName() . '.`title`';

        return self::find()
            ->joinWith(['lang'])
            ->orderBy(implode(',', $order));
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

    /**
     * Drop down list
     *
     * @param int $country_id
     * @return mixed
     */
    public static function dropDownList($country_id = 0)
    {
        $query = self::findBase();

        if ($country_id) {
            $query->andFilterWhere(['country_id' => $country_id]);
        }

        $data = $query->all();

        return ArrayHelper::map($data, 'id', 'lang.title');
    }
}
