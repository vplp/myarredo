<?php
use backend\app\bootstrap\ActiveForm;

use backend\modules\feedback\models\Group;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'group_id')->dropDownList(Group::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose group') . '---']) ?>
<?= $form->text_line($model, 'user_name') ?>
<?= $form->text_line($model, 'email') ?>
<?= $form->text_line($model, 'subject') ?>
<?= $form->text_line($model, 'question') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
