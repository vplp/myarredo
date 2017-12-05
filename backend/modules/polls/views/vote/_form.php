<?php
use yii\helpers\Html;
//
use backend\app\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?= Html::activeHiddenInput($model, 'group_id', ['value' => $this->context->group->id]) ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'published') ?>
        </div>
        <div class="col-md-3">
            <?= $form->text_line($model, 'position') ?>
        </div>
    </div>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>