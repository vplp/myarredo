<?php
use thread\app\bootstrap\ActiveForm;
//
use backend\modules\user\models\{
    Group, User
};

/**
 * @var User $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'username') ?>
<?= $form->text_line($model, 'email') ?>
<?php if ($model['id'] != 1): echo $form->field($model, 'group_id')->dropDownList(Group::dropDownList()); endif; ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
