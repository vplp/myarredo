<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use voskobovich\behaviors\ManyToManyBehavior;
use common\modules\user\User as UserModule;
use common\modules\location\models\{
    City, Country
};
use common\modules\shop\models\Order;
use common\modules\catalog\models\Factory;
use common\modules\catalog\models\FactorySubdivision;

/**
 * Class Profile
 *
 * @property string $phone
 * @property string $phone2
 * @property string $additional_phone
 * @property string $email_company
 * @property string $website
 * @property string $exp_with_italian
 * @property boolean $delivery_to_other_cities
 * @property int $country_id
 * @property int $city_id
 * @property int $factory_id
 * @property float $latitude
 * @property float $longitude
 * @property float $latitude2
 * @property float $longitude2
 * @property string $working_hours_start
 * @property string $working_hours_end
 * @property string $working_hours_start2
 * @property string $working_hours_end2
 * @property int $partner_in_city
 * @property int $partner_in_city_paid
 * @property int $possibility_to_answer
 * @property int $possibility_to_answer_sale_italy
 * @property int $possibility_to_answer_com_de
 * @property int $pdf_access
 * @property int $show_contacts
 * @property int $show_contacts_on_sale
 * @property int $factory_package
 * @property string $cape_index
 * @property string $image_link
 * @property string $image_salon
 * @property string $image_salon2
 * @property integer $mark
 * @property string $language_editing
 * @property boolean $three_answers_per_month
 * @property boolean $one_answer_per_month
 * @property boolean $working_conditions
 *
 * @property Country $country
 * @property City $city
 * @property Factory $factory
 * @property FactorySubdivision[] $factorySubdivision
 *
 * @property ProfileLang $lang
 *
 * @package common\modules\user\models
 */
class Profile extends \thread\modules\user\models\Profile
{
    public $country_cities_1 = [];
    public $country_cities_2 = [];
    public $country_cities_3 = [];
    public $country_cities_4 = [];

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
                    'country_ids' => 'countries',
                ],
            ],
        ]);
    }

    /**
     * @return array
     */
    public static function factoryPackageKeyRange()
    {
        return [
            1 => Yii::t('app', 'START edition'),
            2 => Yii::t('app', 'TOP edition'),
        ];
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
                    'phone2',
                    'additional_phone',
                    'email_company',
                    'website',
                    'exp_with_italian',
                    'cape_index',
                    'image_link',
                    'image_salon',
                    'image_salon2',
                    'working_hours_start',
                    'working_hours_end',
                    'working_hours_start2',
                    'working_hours_end2'
                ],
                'string',
                'max' => 255
            ],
            [['email_company'], 'email'],
            [
                [
                    'delivery_to_other_cities',
                    'partner_in_city',
                    'partner_in_city_paid',
                    'possibility_to_answer',
                    'possibility_to_answer_sale_italy',
                    'possibility_to_answer_com_de',
                    'pdf_access',
                    'show_contacts',
                    'show_contacts_on_sale',
                    'three_answers_per_month',
                    'one_answer_per_month',
                    'working_conditions',
                    'mark'
                ],
                'in',
                'range' => array_keys(self::statusKeyRange())
            ],
            [
                'factory_package',
                'in',
                'range' => array_keys(self::factoryPackageKeyRange())
            ],
            [['country_id', 'city_id', 'factory_id'], 'integer'],
            [['latitude', 'longitude', 'latitude2', 'longitude2'], 'double'],
            [
                [
                    'city_ids',
                    'country_ids',
                    'country_cities_1',
                    'country_cities_2',
                    'country_cities_3',
                    'country_cities_4',
                ],
                'each',
                'rule' => ['integer']
            ],
            [['language_editing'], 'string', 'max' => 5],
            [['language_editing'], 'default', 'value' => '']
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'mark' => ['mark'],
            'ownEdit' => [
                'first_name',
                'last_name',
                'phone',
                'phone2',
                'email_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'factory_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude',
                'latitude2',
                'longitude2',
                'working_hours_start',
                'working_hours_end',
                'working_hours_start2',
                'working_hours_end2',
                'partner_in_city',
                'partner_in_city_paid',
                'possibility_to_answer',
                'possibility_to_answer_sale_italy',
                'possibility_to_answer_com_de',
                'working_conditions',
                'pdf_access',
                'show_contacts',
                'show_contacts_on_sale',
                'cape_index',
                'image_link',
                'image_salon',
                'image_salon2',
                'mark',
                'language_editing',
            ],
            'basicCreate' => [
                'phone',
                'phone2',
                'email_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'factory_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude',
                'latitude2',
                'longitude2',
                'working_hours_start',
                'working_hours_end',
                'working_hours_start2',
                'working_hours_end2',
                'partner_in_city',
                'partner_in_city_paid',
                'possibility_to_answer',
                'possibility_to_answer_sale_italy',
                'possibility_to_answer_com_de',
                'working_conditions',
                'pdf_access',
                'show_contacts',
                'show_contacts_on_sale',
                'preferred_language',
                'factory_package',
                'cape_index',
                'image_link',
                'image_salon',
                'image_salon2',
                'mark',
                'language_editing',
            ],
            'backend' => [
                'first_name',
                'last_name',
                'phone',
                'phone2',
                'additional_phone',
                'email_company',
                'website',
                'exp_with_italian',
                'country_id',
                'city_id',
                'factory_id',
                'delivery_to_other_cities',
                'latitude',
                'longitude',
                'latitude2',
                'longitude2',
                'working_hours_start',
                'working_hours_end',
                'working_hours_start2',
                'working_hours_end2',
                'partner_in_city',
                'partner_in_city_paid',
                'possibility_to_answer',
                'possibility_to_answer_sale_italy',
                'possibility_to_answer_com_de',
                'pdf_access',
                'show_contacts',
                'show_contacts_on_sale',
                'city_ids',
                'country_ids',
                'country_cities_1',
                'country_cities_2',
                'country_cities_3',
                'country_cities_4',
                'cape_index',
                'image_link',
                'image_salon',
                'image_salon2',
                'mark',
                'language_editing',
                'three_answers_per_month',
                'one_answer_per_month',
                'working_conditions',
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
            'phone2' => Yii::t('app', 'Телефон 2-го салона'),
            'additional_phone' => Yii::t('app', 'Телефон для подмены'),
            'email_company' => Yii::t('app', 'E-mail company'),
            'website' => Yii::t('app', 'Адресс сайта'),
            'exp_with_italian' => Yii::t('app', 'Опыт работы с итальянской мебелью, лет'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'factory_id' => Yii::t('app', 'Factory'),
            'delivery_to_other_cities' => Yii::t('app', 'Готов к поставкам мебели в другие города'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'latitude2' => Yii::t('app', 'Latitude'),
            'longitude2' => Yii::t('app', 'Longitude'),
            'working_hours_start' => Yii::t('app', 'Working hours start'),
            'working_hours_end' => Yii::t('app', 'Working hours end'),
            'working_hours_start2' => Yii::t('app', 'Working hours start'),
            'working_hours_end2' => Yii::t('app', 'Working hours end'),
            'partner_in_city' => Yii::t('app', 'Partner in city'),
            'partner_in_city_paid' => Yii::t('app', 'Partner in city paid'),
            'possibility_to_answer' => Yii::t('app', 'Отвечает без установки кода на сайт'),
            'possibility_to_answer_sale_italy' => Yii::t('app', 'Отвечает на заявки Итальянской распродажи'),
            'possibility_to_answer_com_de' => 'Отвечает на заявки myarredo.com  myarredo.de myarredofamily.com',
            'pdf_access' => Yii::t('app', 'Доступ к прайсам и каталогам'),
            'show_contacts' => Yii::t('app', 'Показывать в контактах'),
            'show_contacts_on_sale' => Yii::t('app', 'Показывать контакты в распродаже'),
            'city_ids' => Yii::t('app', 'Ответы в городах'),
            'country_ids' => Yii::t('app', 'Ответы в странах'),
            'factory_package' => Yii::t('app', 'Package'),
            'cape_index' => Yii::t('app', 'CAPE index'),
            'image_link' => Yii::t('app', 'Image link'),
            'image_salon' => Yii::t('app', 'Image link'),
            'image_salon2' => Yii::t('app', 'Image link'),
            'mark',
            'language_editing',
            'three_answers_per_month' => Yii::t('app', 'Three answers per month'),
            'one_answer_per_month' => Yii::t('app', 'One answer per month'),
            'working_conditions' => Yii::t('app', 'Условия работы'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function afterFind()
    {
        foreach ($this->cities as $city) {
            $field = 'country_cities_' . $city['country_id'];
            $this->$field[$city['id']] = $city['id'];
        }

        if ($this->selected_languages != null) {
            $this->selected_languages = explode('/', $this->selected_languages);
            $this->selected_languages = array_filter($this->selected_languages, fn($value) => !is_null($value) && $value !== '');
            $this->selected_languages = array_values($this->selected_languages);
        }

        parent::afterFind();
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['backend'])) {
            $this->city_ids = [];
            $this->city_ids = array_merge($this->city_ids, is_array($this->country_cities_1) ? $this->country_cities_1 : []);
            $this->city_ids = array_merge($this->city_ids, is_array($this->country_cities_2) ? $this->country_cities_2 : []);
            $this->city_ids = array_merge($this->city_ids, is_array($this->country_cities_3) ? $this->country_cities_3 : []);
            $this->city_ids = array_merge($this->city_ids, is_array($this->country_cities_4) ? $this->country_cities_4 : []);
        }

        if (in_array($this->scenario, ['frontend', 'backend', 'basicCreate'])) {
            $this->mark = '0';
            $this->language_editing = Yii::$app->language;
        }

        if (is_array($this->selected_languages) && !empty($this->selected_languages)) {
            $this->selected_languages = '/' . implode('/', array_filter($this->selected_languages)) . '/';
        } else {
            $this->selected_languages = '//';
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(ProfileLang::class, ['rid' => 'id']);
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getCities()
    {
        return $this
            ->hasMany(City::class, ['id' => 'location_city_id'])
            ->viaTable('fv_user_rel_location_city', ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getCountries()
    {
        return $this
            ->hasMany(Country::class, ['id' => 'location_country_id'])
            ->viaTable('fv_user_rel_location_country', ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getFactorySubdivision()
    {
        return $this->hasMany(FactorySubdivision::class, ['user_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getNameCompany()
    {
        return (isset($this->lang->name_company)) ? $this->lang->name_company : "";
    }

    /**
     * @return mixed
     */
    public function getCountryTitle()
    {
        $model = Country::findById($this->country_id);

        if ($model == null || empty($model->lang)) {
            return false;
        } else {
            return $model->lang->title;
        }
    }

    /**
     * @return mixed
     */
    public function getCityTitle()
    {
        $model = City::findById($this->city_id);

        if ($model == null || empty($model->lang)) {
            return false;
        } else {
            return $model->lang->title;
        }
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
        if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['admin', 'settlementCenter', 'catalogEditor']) ||
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
     * @param Order $modelOrder
     * @return bool
     * @throws \Throwable
     */
    public function getPossibilityToAnswer(Order $modelOrder = null)
    {
        if (in_array(Yii::$app->user->identity->group->role, ['partner', 'factory', 'settlementCenter']) && $modelOrder && $modelOrder->country_id) {
            $modelCountries = Yii::$app->getUser()->getIdentity()->profile->countries;
            if ($modelCountries != null) {
                foreach ($modelCountries as $item) {
                    if ($item['id'] == $modelOrder->country_id) {
                        return true;
                    }
                }
            }
        }

        if ($modelOrder && $modelOrder->orderRelUserForAnswer) {
            foreach ($modelOrder->orderRelUserForAnswer as $user) {
                if ($user->id == Yii::$app->user->identity->id) {
                    return true;
                }
            }
        }

        if (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->country_id &&
            Yii::$app->user->identity->profile->country_id == 4) {
            return true;
        } elseif (in_array(Yii::$app->user->identity->group->role, ['admin', 'logistician', 'settlementCenter'])) {
            return true;
        } elseif (Yii::$app->getUser()->getIdentity()->profile->possibility_to_answer) {
            return true;
        } elseif (Yii::$app->getUser()->getIdentity()->profile->website) {
            $html = $this->getCurlData(Yii::$app->getUser()->getIdentity()->profile->website);

            $matches = array();

            preg_match_all('/<a href="(.*?)"/s', $html, $matches);

            if (in_array('https://www.myarredo.ru/', $matches[1])) {
                return true;
            } elseif (in_array('https://www.myarredo.ua/', $matches[1])) {
                return true;
            } elseif (in_array('https://www.myarredo.by/', $matches[1])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $country_id
     * @return bool
     * @throws \Throwable
     */
    public function getPossibilityToAnswerSaleItaly()
    {
        if (in_array(Yii::$app->user->identity->group->role, ['logistician'])) {
            return true;
        } elseif (Yii::$app->getUser()->getIdentity()->profile->possibility_to_answer_sale_italy) {
            return true;
        }

        return false;
    }


    public function getPossibilityToAnswerComDe()
    {
        if (in_array(Yii::$app->user->identity->group->role, ['logistician'])) {
            return true;
        } elseif (Yii::$app->getUser()->getIdentity()->profile->possibility_to_answer_com_de) {
            return true;
        }

        return false;
    }

    /**
     * @param int $country_id
     * @return bool
     * @throws \Throwable
     */
    public function getPossibilityToAnswerForFactory($country_id = 0)
    {
        if (Yii::$app->user->identity->group->role == 'factory' && $country_id) {
            $modelCountries = Yii::$app->getUser()->getIdentity()->profile->countries;
            if ($modelCountries != null) {
                foreach ($modelCountries as $item) {
                    if ($item['id'] == $country_id) {
                        return true;
                    }
                }
            }
        } else if (Yii::$app->user->identity->group->role == 'factory') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function getPossibilityToSaveAnswerPerMonth()
    {
        if (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->three_answers_per_month &&
            Yii::$app->user->identity->getOrderAnswerCountPerMonth() >= 3) {
            return false;
        } elseif (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->one_answer_per_month &&
            Yii::$app->user->identity->getOrderAnswerCountPerMonth() >= 1) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param Order $modelOrder
     * @return bool
     * @throws \Throwable
     */
    public function getPossibilityToSaveAnswer(Order $modelOrder)
    {
        /**
         * Answers per month
         */
        if ($this->getPossibilityToSaveAnswerPerMonth() == false) {
            return false;
        }

        if (in_array(Yii::$app->user->identity->group->role, ['logistician'])) {
            return true;
        } elseif (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->country_id &&
            Yii::$app->user->identity->profile->country_id == 4) {
            return true;
        } elseif (in_array(Yii::$app->user->identity->group->role, ['partner']) && $modelOrder->country_id) {
            $modelCountries = Yii::$app->user->identity->profile->countries;
            if ($modelCountries != null) {
                foreach ($modelCountries as $item) {
                    if ($item['id'] == $modelOrder->country_id) {
                        return true;
                    }
                }
            }
        }

        $modelCities = Yii::$app->getUser()->getIdentity()->profile->cities;

        if ($modelCities != null) {
            foreach ($modelCities as $item) {
                if ($item['id'] == $modelOrder->city_id) {
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
    private function getCurlData($url)
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

    /**
     * @param string $field
     * @return string|null
     */
    public function getImageLink($field = 'image_link')
    {
        /** @var UserModule $module */
        $module = Yii::$app->getModule('user');

        $path = $module->getAvatarUploadPath($this->user_id);
        $url = $module->getAvatarUploadUrl($this->user_id);

        $image = null;

        if (!empty($this->$field) && is_file($path . '/' . $this->$field)) {
            $image = $url . '/' . $this->$field;
        }

        return $image;
    }
}
