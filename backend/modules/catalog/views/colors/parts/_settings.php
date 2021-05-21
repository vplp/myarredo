<?php

use kartik\color\ColorInput;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Colors, ColorsLang
};

/**
 * @var $model Colors
 * @var $modelLang ColorsLang
 * @var $form ActiveForm
 */

?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'plural_title') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_en') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_it') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_de') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_fr') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_he') ?>
    </div>
</div>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form
            ->field($model, 'color_code')
            ->widget(
                ColorInput::class,
                [
                    'options' => ['placeholder' => 'Select color ...'],
                ]
            ) ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
