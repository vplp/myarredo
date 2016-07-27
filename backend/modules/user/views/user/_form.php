<?php
use backend\modules\user\models\Group;
use thread\modules\user\models\User;
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var User $model
 */
$form = ActiveForm::begin();
?>
<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>
<?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'group_id')->dropDownList(Group::dropDownList()); ?>
<?= $form->field($model, 'published')->checkbox(); ?>
<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>
<?php ActiveForm::end();
