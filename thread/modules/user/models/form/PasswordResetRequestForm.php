<?php

namespace thread\modules\user\models\form;

use Yii;
//
use thread\modules\user\models\User;

/**
 * Class PasswordResetRequestForm
 *
 * @package thread\modules\user\models\form
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PasswordResetRequestForm extends CommonForm
{
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */


    /**
     * Создаем токкен для сброса пароля
     * @return bool
     */
    public function generateResetToken()
    {
        $success = false;
        $user = $this->getUserByEmail();
        if ($user) {
            $user->setScenario('resetPassword');
            $user->generatePasswordResetToken();

            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            $success = $user->save();
        }
        return $success;
    }


    /**
     * @return bool
     */
    public function sendEmail()
    {
        /** @see runtime/fronend/debug/mail directory */
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $this->getUserByEmail()]
            )
            ->setTo($this->email)
            ->setSubject('Password reset for ' . \Yii::$app->name)
            ->send();
    }


    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'remind' => ['email'],
        ];
    }
}
