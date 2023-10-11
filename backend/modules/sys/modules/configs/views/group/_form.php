<?php

use backend\app\bootstrap\ActiveForm;

/**
 * @var $model \backend\modules\sys\modules\configs\models\Group
 * @var $modelLang \backend\modules\sys\modules\configs\models\GroupLang
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>

<?php ActiveForm::end(); ?>
