<?php

use thread\app\bootstrap\{
    ActiveForm
};

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'factory_id')->input('hidden')->label(false) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>