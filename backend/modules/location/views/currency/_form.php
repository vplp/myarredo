<?php
use thread\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\location\models\Currency $model
 * @var \backend\modules\location\models\CurrencyLang $modelLang
 * @var ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'code1') ?>
<?= $form->text_line($model, 'code2') ?>
<?= $form->text_line($model, 'course') ?>
<?= $form->text_line($model, 'currency_symbol') ?>
<?= $form->switcher($model, 'published') ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
