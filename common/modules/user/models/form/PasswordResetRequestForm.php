<?php

namespace common\modules\user\models\form;

use yii\helpers\ArrayHelper;

/**
 * Class PasswordResetRequestForm
 *
 * @package common\modules\user\models\form
 */
class PasswordResetRequestForm extends \thread\modules\user\models\form\PasswordResetRequestForm
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
            [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => '_reCaptcha_SECRET',
                'uncheckedMessage' => 'Please confirm that you are not a bot.'
            ]
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
}
