<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use common\modules\location\models\{
    City, Country
};
use common\modules\catalog\models\Factory;

/**
 * Class Profile
 *
 * @property string $phone
 * @property string $additional_phone
 * @property string $address
 * @property string $name_company
 * @property string $email_company
 * @property string $website
 * @property string $exp_with_italian
 * @property boolean $delivery_to_other_cities
 * @property int $country_id
 * @property int $city_id
 * @property int $factory_id
 * @property float $latitude
 * @property float $longitude
 * @property int $partner_in_city
 * @property int $possibility_to_answer
 * @property int $pdf_access
 * @property int $show_contacts
 *
 * @property Country $country
 * @property City $city
 *
 * @package common\modules\user\models
 */
class Profile extends \thread\modules\user\models\Profile
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
            [
                [
                    'phone',
                    'additional_phone',
                    'address',
                    'name_company',
                    'email_company',
                    'website',
                    'exp_with_italian'
                ],
                'string',
                'max' => 255
            ],
            [['email_company'], 'email'],
            [
                [
                    'delivery_to_other_cities',
                    'partner_in_city',
                    'possibility_to_answer',
                    'pdf_access',
                    'show_contacts'
                ],
                'in',
                'range' => array_keys(self::statusKeyRange())
            ],
            [['country_id', 'city_id', 'factory_id'], 'integer'],
            [['latitude', 'longitude'], 'double'],
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
            'ownEdit' => [
                'first_name',
                'last_name',
                'phone',
                'address',
                'name_company',
                'email_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'factory_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude',
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access',
                'show_contacts',
            ],
            'basicCreate' => [
                'phone',
                'address',
                'name_company',
                'email_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'factory_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude',
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access',
                'show_contacts',
            ],
            'backend' => [
                'first_name',
                'last_name',
                'phone',
                'additional_phone',
                'address',
                'name_company',
                'email_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'factory_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude',
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access',
                'show_contacts',
                'city_ids'
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
            'additional_phone' => 'Телефон для подмены',
            'address' => 'Адресс',
            'name_company' => 'Название компании',
            'email_company' => 'E-mail',
            'website' => 'Адресс сайта',
            'exp_with_italian' => 'Опыт работы с итальянской мебелью, лет',
            'country_id' => 'Ваша страна',
            'city_id' => 'Ваш город',
            'factory_id' => 'Фабрика',
            'delivery_to_other_cities' => 'Готов к поставкам мебели в другие города',
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'partner_in_city' => Yii::t('app', 'Partner in city'),
            'possibility_to_answer' => 'Отвечает без установки кода на сайт',
            'pdf_access' => 'Доступ к прайсам и каталогам',
            'show_contacts' => 'Показывать в контактах',
            'city_ids' => 'Ответы в городах',
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
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'location_city_id'])
            ->viaTable('fv_user_rel_location_city', ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return mixed
     */
    public function getCountryTitle()
    {
        $model = Country::findById($this->country_id);

        if ($model == null || empty($model->lang))
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

        if ($model == null || empty($model->lang))
            return false;
        else
            return $model->lang->title;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return ($this->additional_phone != '')
            ? $this->additional_phone
            : $this->phone;
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function isPdfAccess()
    {
        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin']) ||
            (
                in_array(Yii::$app->getUser()->getIdentity()->group->role, ['partner']) &&
                Yii::$app->getUser()->getIdentity()->profile->pdf_access
            )
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function getPossibilityToAnswer()
    {
        if (Yii::$app->getUser()->getIdentity()->profile->possibility_to_answer) {
            return true;
        } else if (Yii::$app->getUser()->getIdentity()->profile->website) {

            $html = $this->get_data(Yii::$app->getUser()->getIdentity()->profile->website);

            $matches = array();

            preg_match_all('/<a href="(.*?)"/s', $html, $matches);

            if (in_array('http://www.myarredo.ru/', $matches[1])) {
                return true;
            } elseif (in_array('http://www.myarredo.ua/', $matches[1])) {
                return true;
            } elseif (in_array('http://www.myarredo.by/', $matches[1])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $city_id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function getPossibilityToSaveAnswer($city_id = 0)
    {
        $modelCities = Yii::$app->getUser()->getIdentity()->profile->cities;

        if ($modelCities != null) {
            foreach ($modelCities as $item) {
                if($item['id'] == $city_id) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param $url
     * @return mixed
     */
    private function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}
