<?php

use kartik\widgets\Select2;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};
use backend\modules\user\models\User;

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

echo $form
    ->field($model, 'dealers_ids')
    ->widget(Select2::class, [
        'data' => User::dropDownListPartner(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) . $form->switcher($model, 'dealers_can_answer') ;
