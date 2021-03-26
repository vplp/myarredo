<?php

namespace frontend\modules\user\models\form;

use yii\helpers\ArrayHelper;

/**
 * Class RegisterForm
 *
 * @package frontend\modules\user\models\form
 */
class RegisterForm extends \common\modules\user\models\form\RegisterForm
{
    public $subdivision_in_cis;
    public $subdivision_in_italy;
    public $subdivision_in_europe;

    public function rules()
    {
        $rules = [
            [
                [
                    'subdivision_in_cis',
                    'subdivision_in_italy',
                    'subdivision_in_europe',
                ],
                'in',
                'range' => [0, 1]
            ],
        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    public function attributeLabels()
    {
        $attributeLabels = [
            'subdivision_in_cis' => 'Представительство в Странах СНГ',
            'subdivision_in_italy' => 'Представительство в Италии',
            'subdivision_in_europe' => 'Представительство в Европе',
        ];

        return ArrayHelper::merge($attributeLabels, parent::attributeLabels());
    }

    public function scenarios()
    {
        $scenarios = [
        ];

        return ArrayHelper::merge($scenarios, parent::scenarios());
    }
}
