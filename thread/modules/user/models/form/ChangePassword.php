<?php

namespace thread\modules\user\models\form;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class ChangePasswordForm
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class ChangePassword extends CommonForm
{

    const FLASH_KEY = 'ChangePassword';

    /** @var bool */
    public $isNewRecord = false;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['password_confirmation'], 'required'],
            [['password', 'password_old'], 'required'],
            [['password_old'], 'validateOLDPassword'],
            [['password_confirmation'], 'compare', 'compareAttribute' => 'password',],
            [['password', 'password_confirmation'], 'required'],
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            [
                'passwordChange' => ['password', 'password_confirmation', 'password_old'],
            ],
            parent::scenarios()
        );
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

}
