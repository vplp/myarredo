<?php

use backend\app\bootstrap\ActiveForm;
//
use backend\modules\sys\modules\configs\models\Group;

/**
 * @var $model \backend\modules\sys\modules\configs\models\Params
 * @var $modelLang \backend\modules\sys\modules\configs\models\ParamsLang
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>
<?= $form->field($model, 'group_id')->dropDownList(Group::dropDownList(), ['promt' => '---' . Yii::t('app', 'Choose group') . '---']) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->text_editor($model, 'value') ?>
<?= $form->submit($model, $this) ?>

<?php ActiveForm::end(); ?>
