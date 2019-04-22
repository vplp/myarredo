<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\models\Language;

/** @var $model Language */

$form = ActiveForm::begin();
echo $form->submit($model, $this);
echo $form->text_line($model, 'alias');
echo $form->text_line($model, 'local');
echo $form->text_line($model, 'label');
echo $form->field($model, 'img_flag')->imageOne($model->getFlagUploadUrl());
echo $form->checkbox($model, 'by_default');
if ($model['by_default'] != $model::STATUS_KEY_ON) {
    echo $form->switcher($model, 'published');
}
echo $form->submit($model, $this);
ActiveForm::end();
