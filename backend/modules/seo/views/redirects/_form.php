<?php

use thread\app\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>

<?= $form->text_line($model, 'url_from') ?>
<?= $form->text_line($model, 'url_to') ?>
<?= $form->switcher($model, 'published') ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
