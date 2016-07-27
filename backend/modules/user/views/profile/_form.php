<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;
use yii\helpers\Html;

/**
 * @var \backend\modules\user\models\Profile $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>
<?= $form->field($model, 'first_name')->textInput(['maxlength']); ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength']); ?>
<?= $form->field($model, 'avatar')->imageOne(); ?>
<?= $form->field($model, 'preferred_language')->dropDownList(\Yii::$app->params['themes']['languages']); ?>
<?= Html::a(Yii::t('app', 'Change password'), ['password-change', 'id' => $model['id']], ['class' => 'btn btn-info']); ?>
<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>
<?php ActiveForm::end();
