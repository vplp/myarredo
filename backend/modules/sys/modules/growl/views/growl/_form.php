<?php
use backend\app\bootstrap\ActiveForm;
use backend\modules\user\models\User;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($model, 'model') ?>
<?= $form->text_line($model, 'user_id')->selectOne(User::dropDownList()) ?>
<?= $form->field($model, 'type')->dropDownList($model::getTypeRange()) ?>
<?= $form->text_line($model, 'url') ?>
<?= $form->text_line($model, 'message') ?>
<?= $form->switcher($model, 'is_read') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
