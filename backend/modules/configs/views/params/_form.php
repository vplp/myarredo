<?php
use thread\app\bootstrap\ActiveForm;
//
use backend\modules\configs\models\Group;

/**
 * @var \backend\modules\news\models\GroupLang $modelLang
 * @var \backend\modules\news\models\Group $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'group_id')->dropDownList(Group::dropDownList(), ['promt' => '---' . Yii::t('app', 'Choose group') . '---']) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line($model, 'value') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
