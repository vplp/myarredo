<?php

use kartik\color\ColorInput;

/**
 * @var \backend\modules\catalog\models\Colors $model
 * @var \backend\modules\catalog\models\ColorsLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?php
if (!$model->isNewRecord) {
    echo $form->text_line($model, 'default_title')->textInput(['disabled' => true]);
} ?>

<?= $form->text_line($model, 'alias') ?>

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