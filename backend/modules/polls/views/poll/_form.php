<?php
use backend\app\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<div class="row control-group">
    <div class="col-md-6">
        <?= $form->field($model, 'start_time')->datePicker($model->getStartTime()) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'finish_time')->datePicker($model->getFinishTime()) ?>
    </div>
</div>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
