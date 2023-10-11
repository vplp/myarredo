<?php

use backend\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\forms\models\FormsFeedback $model
 */

$form = ActiveForm::begin();
echo $form->submit($model, $this)
    . $form->field($model, 'name')
    . $form->field($model, 'phone')
    . $form->field($model, 'email')
    . $form->field($model, 'question')
    . $form->submit($model, $this);
ActiveForm::end();
