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


    public function rules()
    {
        $rules = [

        ];

        return ArrayHelper::merge($rules, parent::rules());
    }

    public function attributeLabels()
    {
        $attributeLabels = [
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
