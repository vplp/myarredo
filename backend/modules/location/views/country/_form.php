<?php
use thread\app\bootstrap\ActiveForm;

/**
 * @var ActiveForm $form
 * @var \backend\modules\location\models\Country $model
 * @var \backend\modules\location\models\CountryLang $modelLang
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'alpha2') ?>
<?= $form->text_line($model, 'alpha3') ?>
<?= $form->text_line($model, 'iso') ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
