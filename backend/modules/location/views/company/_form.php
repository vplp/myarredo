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


<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'street')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'house')->textInput(['maxlength' => true]); ?>

<?= $form->field($model, 'country_id')->dropDownList(\backend\modules\location\models\Country::dropDownList()); ?>
<?= $form->field($model, 'city_id')->dropDownList(\backend\modules\location\models\City::dropDownList()); ?>
<?= $form->field($model, 'published')->checkbox(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?php ActiveForm::end();
