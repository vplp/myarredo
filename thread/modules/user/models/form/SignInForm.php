<?php
namespace thread\modules\user\models\form;

use Yii;
//
use thread\modules\user\models\Group;

/**
 * Class SignInForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
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
            if ($user !== null && $this->ONLY_ADMIN === true) {
                if ($user['group_id'] != Group::ADMIN) {
                    $this->addError($this->password, Yii::t('app', 'User access is prohibited'));
                }
            }
            if ($this->validatePassword()) {
                return Yii::$app->getUser()->login($user, $this->rememberMe ? $this->getTimeRememberUserSignIn() : 0);
            } else {
                $this->addError($this->password, Yii::t('app', 'Incorrect username or password.'));
            }
        }
        return false;
    }
}
