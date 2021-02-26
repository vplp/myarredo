<?php

namespace common\modules\user\models\form;

use Yii;
use yii\base\Model;

//
use common\modules\user\User as UserModule;
use common\modules\user\models\User as UserModel;

/**
 * Class CommonForm
 *
 * @property int $group_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $captcha
 * @property string $password_old
 * @property boolean $rememberMe
 * @property string $password_confirmation
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $address
 * @property string $name_company
 * @property string $website
 * @property string $exp_with_italian
 * @property boolean $delivery_to_other_cities
 * @property int $country_id
 * @property int $city_id
 * @property int $user_agreement
 * @property int $user_confirm_offers
 * @property int $confirm_processing_data
 * @property int $factory_package
 * @property string $cape_index
 *
 * @package thread\modules\user\models\form
 */
class CommonForm extends Model
{
    const FLASH_KEY = 'CommonForm';

    /**
     * attribute
     */
    public $group_id;
    public $username;
    public $email;
    public $password;
    public $captcha;
    public $password_old;
    public $rememberMe = true;
    public $password_confirmation;
    private $_user = null;

    public $first_name;
    public $last_name;
    public $phone;
    public $address;
    public $name_company;
    public $website;
    public $exp_with_italian;
    public $delivery_to_other_cities;
    public $user_agreement;
    public $user_confirm_offers;
    public $factory_confirm_offers;
    public $confirm_processing_data;
    public $country_id;
    public $city_id;
    public $factory_package;
    public $cape_index;

    /**
     * Private attributes.
     * @see \thread\modules\user\User
     */
    protected $_username_attribute;
    protected $_password_min_length;
    protected $_auto_login_after_register;
    protected $_time_remember_user_sign_in;

    public function init()
    {
        /** @var UserModule $module */
        $module = Yii::$app->getModule('user');

        $this->_username_attribute = $module->username_attribute;
        $this->_password_min_length = $module->password_min_length;
        $this->_auto_login_after_register = $module->auto_login_after_register;
        $this->_time_remember_user_sign_in = $module->time_remember_user_sign_in;

        parent::init();
    }

    /**
     * @return object|string|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return UserModule::getDb();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['captcha'], 'captcha'],
            [['password', 'password_confirmation'], 'string', 'min' => $this->_password_min_length],
            [['email'], 'email'],
            [
                ['password_confirmation'],
                'compare',
                'compareAttribute' => 'password',
                'on' => ['adminPasswordChange']
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'address',
                    'name_company',
                    'website',
                    'exp_with_italian',
                    'cape_index'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'delivery_to_other_cities',
                    'user_agreement',
                    'confirm_processing_data',
                    'factory_confirm_offers',
                    'user_confirm_offers'
                ],
                'in',
                'range' => [0, 1]
            ],
            [['factory_package'], 'in', 'range' => [0, 1, 2]],
            [['country_id', 'city_id'], 'integer'],
            [
                [
                    'username',
                    'email',
                    'password',
                    'password_confirmation',
                    'first_name',
                    'last_name',
                    'phone',
                    'address',
                    'name_company',
                    'website',
                ],
                'filter',
                'filter' => 'trim'
            ],
            [
                [
                    'username',
                    'email',
                    'password',
                    'password_confirmation',
                    'first_name',
                    'last_name',
                    'phone',
                    'address',
                    'name_company',
                    'website',
                ],
                'filter',
                'filter' => 'strip_tags'
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'group_id' => Yii::t('app', 'Group'),
            'published' => Yii::t('app', 'Published'),
            'username' => Yii::t('user', 'Username'),
            'password_old' => Yii::t('user', 'Password old'),
            'password' => Yii::t('user', 'Password'),
            'password_confirmation' => Yii::t('user', 'Password confirmation'),
            'email' => Yii::t('app', 'Email'),
            'rememberMe' => Yii::t('app', 'Remember me'),
            // new attributeLabels
            'first_name' => Yii::t('app', 'First name'),
            'last_name' => Yii::t('app', 'Last name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'name_company' => Yii::t('app', 'Название компании'),
            'website' => Yii::t('app', 'Адресс сайта'),
            'exp_with_italian' => Yii::t('app', 'Опыт работы с итальянской мебелью, лет'),
            'country_id' => Yii::t('app', 'Country'),
            'city_id' => Yii::t('app', 'City'),
            'delivery_to_other_cities' => Yii::t('app', 'Готов к поставкам мебели в другие города'),
            'user_agreement' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">пользовательское соглашение</a>'),
            'factory_confirm_offers' => Yii::t('app', 'Подтверждаю <a href="/offer-for-factories/" target="_blank">оферту</a>'),
            'user_confirm_offers' => Yii::t('app', 'Подтверждаю <a href="/logistician-offers/" target="_blank">оферту</a>'),
            'confirm_processing_data' => Yii::t('app', 'Подтверждаю <a href="/terms-of-use/" target="_blank">обработку моих персональных данных</a>'),
            'factory_package' => Yii::t('app', 'Package'),
            'cape_index' => Yii::t('app', 'CAPE index'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'adminPasswordChange' => ['password', 'password_confirmation'],
            'setPassword' => ['password']
        ];
    }

    /**
     * Validated email
     */
    public function validateEmailOnCreate()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUserByEmail();
            if ($user !== null) {
                $this->addError('username', Yii::t('user', 'User exists'));
                $this->addError('email', Yii::t('user', 'User exists'));
            }
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? $this->getTimeRememberUserSignIn() : 0);
        } else {
            return false;
        }
    }

    /**
     * @return null|UserModel
     */
    public function getUser()
    {
        return ($this->_username_attribute === 'username') ? $this->getUserByUserName() : $this->getUserByEmail();
    }

    /**
     * @return null|static
     */
    public function getUserByEmail()
    {
        if ($this->_user === null) {
//            $email = ($this->_username_attribute === 'email') ? $this->email : $this->username;
            $this->_user = UserModel::findByEmail($this->email);
        }
        return $this->_user;
    }

    /**
     * @return null|static
     */
    public function getUserByUserName()
    {
        if ($this->_user === null) {
            $this->_user = UserModel::findByUsername($this->username);
        }
        return $this->_user;
    }

    /**
     * @return bool
     */
    public function getAutoLoginAfterRegister()
    {
        return $this->_auto_login_after_register;
    }

    /**
     * @param bool|true $value
     */
    public function addFlash($value = true)
    {
        Yii::$app->getSession()->addFlash(self::FLASH_KEY, $value);
    }

    /**
     * @return mixed
     */
    public function getFlash()
    {
        return Yii::$app->getSession()->getFlash(self::FLASH_KEY, '');
    }

    /**
     * @return int
     */
    public function getTimeRememberUserSignIn()
    {
        return $this->_time_remember_user_sign_in;
    }

    /**
     * @return string
     */
    public function getUsernameAttribute()
    {
        return $this->_username_attribute;
    }
}
