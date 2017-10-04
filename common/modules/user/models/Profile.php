<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Profile
 *
 * @property string $phone
 * @property string $address
 * @property string $name_company
 * @property string $website
 * @property string $exp_with_italian
 * @property boolean $delivery_to_other_cities
 * @property int $country_id
 * @property int $city_id
 * @property float $latitude
 * @property float $longitude
 *
 * @package common\modules\user\models
 */
class Profile extends \thread\modules\user\models\Profile
{
    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'phone',
                    'address',
                    'name_company',
                    'website',
                    'exp_with_italian'
                ],
                'string',
                'max' => 255
            ],
            [['delivery_to_other_cities'], 'in', 'range' => [0, 1]],
            [['country_id', 'city_id'], 'integer'],
            [['latitude', 'longitude'], 'double'],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'ownEdit' => [
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude'
            ],
            'basicCreate' => [
                'phone',
                'address',
                'name_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude'
            ],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'phone' => Yii::t('app', 'Phone'),
            'address' => 'Адресс',
            'name_company' => 'Название компании',
            'website' => 'Адресс сайта',
            'exp_with_italian' => 'Опыт работы с итальянской мебелью, лет',
            'country_id' => 'Ваша страна',
            'city_id' => 'Ваш город',
            'delivery_to_other_cities' => 'Готов к поставкам мебели в другие города',
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
        ]);
    }
}
