<?php
use yii\helpers\Html;
use backend\app\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'alias')->placeholder(Html::encode($model->getAttributeLabel('alias')))->textInput(['maxlength' => true, 'readonly' => true]); ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'value') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
