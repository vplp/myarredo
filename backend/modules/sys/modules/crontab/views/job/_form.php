<?php
use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\modules\crontab\models\Job;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<div class="form-group">
    <div class="row">
        <div class="col-sm-2">
            <?= $form->text_line($model, 'minute')->dropDownList(Job::minuteRange()) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->text_line($model, 'hour')->dropDownList(Job::hourRange()) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->text_line($model, 'day')->dropDownList(Job::dayRange()) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->text_line($model, 'month')->dropDownList(Job::monthRange()) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->text_line($model, 'weekDay')->dropDownList(Job::weekDayRange()) ?>
        </div>
    </div>
</div>
<?= $form->text_line($model, 'command') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
