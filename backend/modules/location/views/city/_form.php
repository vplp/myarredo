<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var $model \backend\modules\location\models\City
 * @var $modelLang \backend\modules\location\models\CityLang
 * @var $form \backend\themes\inspinia\widgets\forms\ActiveForm
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?= $form->field($model, 'alias')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'location_country_id')->dropDownList(\backend\modules\location\models\Country::dropDownList()); ?>
<?= $form->field($model, 'published')->checkbox(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?php ActiveForm::end();
