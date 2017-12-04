<?php

namespace frontend\modules\user\models\form;

use Yii;

/**
 * Class PasswordResetRequestForm
 *
 * @package frontend\modules\user\models\form
 */
class PasswordResetRequestForm extends \common\modules\user\models\form\PasswordResetRequestForm
{
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
            ->setFrom(Yii::$app->params['mailer']['setFrom'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . \Yii::$app->name)
            ->send();
    }
}
