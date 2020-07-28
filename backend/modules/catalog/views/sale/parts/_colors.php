<?php

use kartik\widgets\Select2;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\Colors;
use backend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $form ActiveForm
 * @var $model Sale $model
 * @var $modelLang SaleLang
 */

echo $form
    ->field($model, 'colors_ids')
    ->widget(Select2::class, [
        'data' => Colors::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]);
