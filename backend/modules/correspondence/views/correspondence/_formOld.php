<?php
use thread\app\bootstrap\ActiveForm;
//
use backend\modules\user\models\User;

/**
 * @var \backend\modules\news\models\Group $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'recipient_id')->dropDownList(User::dropDownList()) ?>
<?= $form->text_line_lang($model, 'subject') ?>
<?= $form->text_editor_lang($model, 'message') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
