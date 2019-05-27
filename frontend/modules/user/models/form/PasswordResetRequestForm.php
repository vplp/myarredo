<?php

namespace frontend\modules\user\models\form;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class PasswordResetRequestForm
 *
 * @package frontend\modules\user\models\form
 */
class PasswordResetRequestForm extends \common\modules\user\models\form\PasswordResetRequestForm
{
    public $reCaptcha;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [
                [
                    'email', 'reCaptcha'
                ],
                'required',
                'on' => 'remind'
            ],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class]
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }


    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'remind' => ['email', 'reCaptcha'],
        ];
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
}
