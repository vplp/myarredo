<?php

namespace common\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
//
use voskobovich\behaviors\ManyToManyBehavior;
//
use common\modules\user\User as UserModule;
use common\modules\location\models\{
    City, Country
};
use common\modules\catalog\models\Factory;

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
 * @property int $partner_in_city
 * @property int $possibility_to_answer
 * @property int $pdf_access
 * @property int $show_contacts
 * @property int $show_contacts_on_sale
 * @property int $factory_package
 * @property string $cape_index
 * @property string $image_link
 * @property integer $mark
 * @property string $language_editing
 * @property boolean $answers_per_month
 *
 * @property Country $country
 * @property City $city
 *
 * @property ProfileLang $lang
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
                    'image_link'
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
                    'show_contacts',
                    'show_contacts_on_sale',
                    'answers_per_month',
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
            [['latitude', 'longitude'], 'double'],
            [
                [
                    'city_ids',
                ],
                'each',
                'rule' => ['integer']
            ],
            [['language_editing'], 'string', 'max' => 5],
            [['language_editing'], 'default', 'value' => ''],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'setMark' => ['mark'],
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
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access',
                'show_contacts',
                'show_contacts_on_sale',
                'cape_index',
                'image_link',
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
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access',
                'show_contacts',
                'show_contacts_on_sale',
                'preferred_language',
                'factory_package',
                'cape_index',
                'image_link',
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
                'partner_in_city',
                'possibility_to_answer',
                'pdf_access',
                'show_contacts',
                'show_contacts_on_sale',
                'city_ids',
                'cape_index',
                'image_link',
                'mark',
                'language_editing',
                'answers_per_month'
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
            'email_company' => Yii::t('app', 'E-mail'),
            'website' => Yii::t('app', 'Адресс сайта'),
            'exp_with_italian' => Yii::t('app', 'Опыт работы с итальянской мебелью, лет'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'factory_id' => Yii::t('app', 'Factory'),
            'delivery_to_other_cities' => Yii::t('app', 'Готов к поставкам мебели в другие города'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'partner_in_city' => Yii::t('app', 'Partner in city'),
            'possibility_to_answer' => Yii::t('app', 'Отвечает без установки кода на сайт'),
            'pdf_access' => Yii::t('app', 'Доступ к прайсам и каталогам'),
            'show_contacts' => Yii::t('app', 'Показывать в контактах'),
            'show_contacts_on_sale' => Yii::t('app', 'Показывать контакты в распродаже'),
            'city_ids' => Yii::t('app', 'Ответы в городах'),
            'factory_package' => Yii::t('app', 'Package'),
            'cape_index' => Yii::t('app', 'CAPE index'),
            'image_link' => Yii::t('app', 'Image link'),
            'mark',
            'language_editing',
            'answers_per_month' => Yii::t('app', '{amount} Answers per month', ['amount' => 3])
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \Throwable
     */
    public function beforeSave($insert)
    {
        if (in_array($this->scenario, ['frontend', 'backend', 'basicCreate'])) {
            $this->mark = '0';
            $this->language_editing = Yii::$app->language;
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
     */
    public function getFactory()
    {
        return $this->hasOne(Factory::class, ['id' => 'factory_id']);
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
        if (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->country_id &&
            Yii::$app->user->identity->profile->country_id == 4) {
            return true;
        } elseif (in_array(Yii::$app->user->identity->group->role, ['logistician'])) {
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
     * @param int $city_id
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function getPossibilityToSaveAnswer($city_id = 0)
    {
        /**
         * Answers per month
         */
        if (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->answers_per_month &&
            Yii::$app->user->identity->getOrderAnswerCountPerMonth() >= 3) {
            return false;
        }

        if (in_array(Yii::$app->user->identity->group->role, ['logistician'])) {
            return true;
        } elseif (in_array(Yii::$app->user->identity->group->role, ['partner']) &&
            Yii::$app->user->identity->profile->country_id &&
            Yii::$app->user->identity->profile->country_id == 4) {
            return true;
        }

        $modelCities = Yii::$app->getUser()->getIdentity()->profile->cities;

        if ($modelCities != null) {
            foreach ($modelCities as $item) {
                if ($item['id'] == $city_id) {
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
     * @return null|string
     */
    public function getImageLink()
    {
        /** @var UserModule $module */
        $module = Yii::$app->getModule('user');

        $path = $module->getAvatarUploadPath($this->user_id);
        $url = $module->getAvatarUploadUrl($this->user_id);

        $image = null;

        if (!empty($this->image_link) && is_file($path . '/' . $this->image_link)) {
            $image = $url . '/' . $this->image_link;
        }

        return $image;
    }
}
