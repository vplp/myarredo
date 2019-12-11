<?php

use backend\modules\catalog\models\Factory;
use backend\modules\user\models\{
    Profile, ProfileLang
};

/** @var $model Profile */
/** @var $modelLang ProfileLang */

if (in_array($model['user']['group_id'], [3])) {
    echo $form->field($model, 'factory_id')
        ->selectOne([0 => '--'] + Factory::dropDownList($model->factory_id));

    echo $form->text_line($model, 'email_company');

    echo $form->text_line($model, 'website')->widget(\yii\widgets\MaskedInput::class, [
        'clientOptions' => [
            'alias' => 'url',
        ],
    ]);

    echo $form->text_line($modelLang, 'address');
}
