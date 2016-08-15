<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var ActiveForm $form
 * @var \backend\modules\location\models\Country $model
 * @var \backend\modules\location\models\CountryLang $modelLang
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?= $form->field($model, 'alpha2')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'alpha3')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'iso')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'published')->checkbox(); ?>


<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?php ActiveForm::end();
