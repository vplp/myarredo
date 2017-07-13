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

    <div class="row control-group">
        <div class="col-md-4">
            <?= $form->text_line($model, 'alpha2') ?>
        </div>
        <div class="col-md-4">
            <?= $form->text_line($model, 'alpha3') ?>
        </div>
        <div class="col-md-4">
            <?= $form->text_line($model, 'iso') ?>
        </div>
    </div>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
