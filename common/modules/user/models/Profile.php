<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\modules\location\models\{
    City, Country
};

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
 * @property int $partner_in_city
 * @property int $possibility_to_answer
 * @property int $pdf_access
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
            [
                [
                    'delivery_to_other_cities',
                    'partner_in_city',
                    'possibility_to_answer',
                    'pdf_access'
                ],
                'in',
                'range' => array_keys(self::statusKeyRange())
            ],
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
                'longitude',
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access'
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
                'longitude',
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access'
            ],
            'backend' => [
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
                'longitude',
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access'
            ]
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
            'partner_in_city' => Yii::t('app', 'Partner in city'),
            'possibility_to_answer' => 'Отвечает без установки кода на сайт',
            'pdf_access' => 'Доступ к прайсам и каталогам',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return mixed
     */
    public function getCountryTitle()
    {
        $model = Country::findById($this->country_id);

        if ($model == null)
            return false;
        else
            return $model->lang->title;
    }

    /**
     * @return mixed
     */
    public function getCityTitle()
    {
        $model = City::findById($this->city_id);

        if ($model == null)
            return false;
        else
            return $model->lang->title;
    }

    /**
     * isPdfAccess
     *
     * @return bool
     */
    public function isPdfAccess()
    {
        if (in_array(Yii::$app->user->identity->group->role, ['admin']) || (
                in_array(Yii::$app->user->identity->group->role, ['partner']) &&
                Yii::$app->user->identity->profile['pdf_access']
            )) {
            return true;
        } else {
            return false;
        }
    }
}
