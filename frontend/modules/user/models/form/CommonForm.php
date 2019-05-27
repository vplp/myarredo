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
}
