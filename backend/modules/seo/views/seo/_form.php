<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var \backend\modules\seo\models\Seo $model
 * @var \backend\modules\seo\models\SeoLang $modelLang
 * @var ActiveForm $model
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?= $form->field($model, 'model_id')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'model_namespace')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'in_search')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'in_robots')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'in_site_map')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'description')->textInput(['maxlength' => true]); ?>
<?= $form->field($modelLang, 'keywords')->textInput(['maxlength' => true]); ?>

<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>

<?php ActiveForm::end();
