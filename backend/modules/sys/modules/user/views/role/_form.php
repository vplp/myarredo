<?php
use backend\app\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($model, 'name') ?>
<?= $form->text_line($model, 'description') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
