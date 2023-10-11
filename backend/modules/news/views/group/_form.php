<?php
use backend\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\news\models\GroupLang $modelLang
 * @var \backend\modules\news\models\Group $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
