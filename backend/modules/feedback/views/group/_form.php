<?php
use thread\app\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'position') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
