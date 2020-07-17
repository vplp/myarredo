<?php

use kartik\widgets\Select2;
use backend\modules\catalog\models\Colors;

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
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
