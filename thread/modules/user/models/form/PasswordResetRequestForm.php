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

    //TODO: Смешано два метода

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findByEmail($this->email);

        $user->setScenario('resetPassword');
        if (!$user) {
            return false;
        }
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
        }
        if (!$user->save()) {
            return false;
        }

        /** @see runtime/fronend/debug/mail directory */
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom(['support@email.ua'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . \Yii::$app->name)
            ->send();
    }
}
