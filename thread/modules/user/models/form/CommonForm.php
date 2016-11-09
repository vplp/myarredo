<?php

namespace thread\modules\user\models\form;

use Yii;
use yii\base\Model;
//
use thread\modules\user\User;
use thread\modules\user\models\User as UserModel;

/**
 * class Common
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CommonForm extends Model
{

    const FLASH_KEY = 'CommonForm';

    //attribute
    public $group_id;
    public $username;
    public $email;
    public $password;
    public $captcha;
    public $password_old;
    public $rememberMe = true;
    public $password_confirmation;
    private $_user = null;

    /**
     * Private attributes.
     * @see \thread\modules\user\User
     */
    private $_username_attribute;
    private $_password_min_length;
    private $_auto_login_after_register;
    private $_time_remember_user_sign_in;

    public function init()
    {
        $this->_username_attribute = Yii::$app->getModule('user')->username_attribute;
        $this->_password_min_length = Yii::$app->getModule('user')->password_min_length;
        $this->_auto_login_after_register = Yii::$app->getModule('user')->auto_login_after_register;
        $this->_time_remember_user_sign_in = Yii::$app->getModule('user')->time_remember_user_sign_in;
        parent::init();
    }

    /**
     * @return string
     */
    public static function getDb()
    {
        return User::getDb();
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['group_id'], 'required', 'on' => ['userCreate']],
            [['username', 'password'], 'required', 'on' => ['signIn', 'register', 'userCreate']],
            [['password_confirmation'], 'required', 'on' => ['register', 'passwordChange', 'userCreate']],
            [['password', 'password_old'], 'required', 'on' => ['passwordChange']],
            [['password', 'password_confirmation'], 'string', 'min' => $this->_password_min_length],
            [['rememberMe'], 'boolean', 'on' => ['sigIn']],
            [['email'], 'validateEmailOnCreate', 'on' => ['userCreate']],
            [['password'], 'validatePassword', 'on' => ['sigIn']],
            [['password_old'], 'validateOLDPassword', 'on' => ['passwordChange']],
            [['captcha'], 'captcha'],
            [
                ['password_confirmation'],
                'compare',
                'compareAttribute' => 'password',
                'on' => ['register', 'passwordChange', 'adminPasswordChange']
            ],
            [['password', 'password_confirmation'], 'required', 'on' => ['adminPasswordChange']],
            [['email'], 'email'],
        ];

        if ($this->_username_attribute === 'email') {
            $rules[] = [['email'], 'required', 'on' => ['userCreate']];
        } elseif ($this->_username_attribute === 'username') {
            $rules[] = ['username', 'required', 'on' => ['userCreate']];
        }
//        var_dump($rules); die;
        return $rules;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'group_id' => Yii::t('app', 'Group'),
            'published' => Yii::t('app', 'Published'),
            'username' => Yii::t('users', 'Username'),
            'password_old' => Yii::t('users', 'Password old'),
            'password' => Yii::t('users', 'Password'),
            'password_confirmation' => Yii::t('users', 'Password confirmation'),
            'email' => Yii::t('app', 'Email'),
            'rememberMe' => Yii::t('app', 'Remember me'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'signIn' => ['username', 'password', 'rememberMe'],
            'register' => ['username', 'email', 'password', 'password_confirmation'],
            'userCreate' => ['username', 'email', 'password', 'password_confirmation', 'group_id', 'published'],
            'remind' => ['email'],
            'passwordChange' => ['password', 'password_confirmation', 'password_old'],
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
                $this->addError('username', Yii::t('users', 'User exists'));
                $this->addError('email', Yii::t('users', 'User exists'));
            }
        }
    }

    /**
     * Validate password_old on password change scenario
     */
    public function validateOLDPassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password_old)) {
                $this->addError('password_old', Yii::t('app', 'Incorrect password.'));
            }
        }
    }

    /**
     * Validate password on signIn scenario
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('app', 'Incorrect username or password.'));
                return false;
            } else {
                return true;
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
            $email = ($this->_username_attribute === 'email') ? $this->username : $this->email;
            $this->_user = UserModel::findByEmail($email);
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
