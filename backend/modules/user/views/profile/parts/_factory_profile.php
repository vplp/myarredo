<?php

use kartik\widgets\Select2;
use backend\modules\catalog\models\Factory;
use backend\modules\user\models\{
    Profile, ProfileLang
};
use backend\modules\location\models\{
    City, Country
};

/** @var $model Profile */
/** @var $modelLang ProfileLang */

if (in_array($model['user']['group_id'], [3])) {
    echo $form->field($model, 'factory_id')
        ->selectOne([0 => '--'] + Factory::dropDownList($model->factory_id));

    echo $form->text_line($model, 'email_company');

    echo $form->text_line($model, 'website');

    echo $form->text_line($modelLang, 'address');

    echo $form
        ->field($model, 'country_ids')
        ->label(Yii::t('app', 'Ответ на заявку из страны'))
        ->widget(Select2::class, [
            'data' => Country::dropDownList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);
}
