<?php

use yii\bootstrap\ActiveForm;
use thread\app\bootstrap\ActiveForm as threadActiveForm;

use thread\modules\user\models\form\CreateForm;
use thread\modules\user\models\User;
use backend\modules\user\models\Group;

/**
 * @var CreateForm|User $model
 */

$f = new threadActiveForm();

$form = ActiveForm::begin();

$model->password_old = '';
$model->password = '';
$model->password_confirmation = '';
?>
<?= $f->submit($model, $this) ?>
<?= $f->text_line($model, 'username') ?>
<?= $f->text_line($model, 'email') ?>
<?= $f->field($model, 'group_id')->selectOne(Group::dropDownList()); ?>
<hr>
<?= $f->text_password($model, 'password') ?>
<?= $f->text_password($model, 'password_confirmation') ?>
<?= $f->switcher($model, 'published') ?>
<?= $f->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
