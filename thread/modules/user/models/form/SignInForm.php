<?php

namespace thread\modules\user\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use thread\modules\user\models\Group;

/**
 * Class SignInForm
 *
 * @package thread\modules\user\models\form
 */
class SignInForm extends CommonForm
{

    const FLASH_KEY = 'SignInForm';

    public $ONLY_ADMIN = false;

    /**
     * @return boolean
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
//            if ($user !== null && $this->ONLY_ADMIN === true) {
//                if ($user['group_id'] != Group::ADMIN) {
//                    Yii::$app->session->addFlash('success', Yii::t('app', 'User access is prohibited'));
//                    $this->addError($this->password, Yii::t('app', 'User access is prohibited'));
//                }
//            }
            if ($this->validatePassword()) {
                return Yii::$app->getUser()->login($user, $this->rememberMe ? $this->getTimeRememberUserSignIn() : 0);
            } else {
                $this->addError($this->password, Yii::t('app', 'Incorrect username or password.'));
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ['signIn' => ['username', 'email', 'password', 'rememberMe']];
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['password'], 'required'],
            [['rememberMe'], 'boolean'],
            [['password'], 'validatePassword']
        ];

        if ($this->_username_attribute === 'email') {
            $rules[] = [['email'], 'required'];
        } elseif ($this->_username_attribute === 'username') {
            $rules[] = [['username'], 'required'];
        }

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return bool
     */
//    public function beforeValidate()
//    {
//        if ($this->_username_attribute === 'email') {
//            $this->email = $this->username;
//        }
//
//        return parent::beforeValidate();
//    }

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
}
