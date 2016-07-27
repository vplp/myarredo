<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;
use thread\widgets\HtmlForm;

/**
 * @var \backend\modules\location\models\Currency $model
 * @var \backend\modules\location\models\CurrencyLang $modelLang
 * @var ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?= $form->field($model, 'alias')->textInput(['maxlength']); ?>
<?= $form->field($modelLang, 'title')->textInput(['maxlength']); ?>
<?= $form->field($model, 'title')->textInput(['maxlength']); ?>
<?= $form->field($model, 'code1')->textInput(['maxlength']); ?>
<?= $form->field($model, 'code2')->textInput(['maxlength']); ?>
<?= $form->field($model, 'course')->textInput(['maxlength']); ?>
<?= $form->field($model, 'currency_symbol')->textInput(['maxlength']); ?>
<?= $form->field($model, 'published')->checkbox(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?php ActiveForm::end();
