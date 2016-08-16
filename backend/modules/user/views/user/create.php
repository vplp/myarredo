<?php

use thread\app\bootstrap\ActiveForm;

use thread\modules\user\models\form\CreateForm;
use thread\modules\user\models\User;
use backend\modules\user\models\Group;

/**
 * @var CreateForm|User $model
 */

$form = ActiveForm::begin();

$model->password_old = '';
$model->password = '';
$model->password_confirmation = '';
?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'username') ?>
<?= $form->text_line($model, 'email') ?>
<?= $form->field($model, 'group_id')->dropDownList(Group::dropDownList()); ?>
<hr>
<?= $form->text_password($model, 'password') ?>
<?= $form->text_password($model, 'password_confirmation') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
