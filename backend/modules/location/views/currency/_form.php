<?php

use backend\app\bootstrap\ActiveForm;

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
    <div class="row control-group">
        <div class="col-md-4">
            <?= $form->text_line($model, 'code1') ?>
        </div>
        <div class="col-md-4">
            <?= $form->text_line($model, 'code2') ?>
        </div>
        <div class="col-md-4">
            <?= $form->text_line($model, 'currency_symbol') ?>
        </div>
    </div>
<?= $form->text_line($model, 'course') ?>
<?= $form->switcher($model, 'published') ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
