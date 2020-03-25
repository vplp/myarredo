<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\location\models\{
    Country, CountryLang
};

/**
 * @var ActiveForm $form
 * @var Country $model
 * @var CountryLang $modelLang
 */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->text_line($model, 'alias') ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->text_line($model, 'bookId') ?>
        </div>
    </div>

<?= $form->text_line_lang($modelLang, 'title') ?>

    <div class="row control-group">
        <div class="col-md-6">
            <?= $form->switcher($model, 'show_for_registration') ?>
        </div>
        <div class="col-md-3">
            <?= $form->switcher($model, 'show_for_filter') ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-6">
            <?= $form->switcher($model, 'published') ?>
        </div>
        <div class="col-md-3">
            <?= $form->text_line($model, 'position') ?>
        </div>
    </div>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
