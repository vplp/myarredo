<?php

namespace frontend\modules\user\models\form;

use yii\helpers\ArrayHelper;

/**
 * Class CommonForm
 *
 * @package frontend\modules\user\models\form
 */
class CommonForm extends \common\modules\user\models\form\CommonForm
{
    public $reCaptcha;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['reCaptcha'], \frontend\widgets\recaptcha3\RecaptchaV3Validator::class, 'acceptance_score' => 0.5]
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
