<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItem, BannerItemLang
};

/**
 * @var $model BannerItem
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

?>

<?= $form->field($model, 'type')->hiddenInput(['value' => 'main'])->label(false) ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line_lang($modelLang, 'description') ?>

<?= $form->text_line_lang($modelLang, 'link') ?>

<div class="row control-group">
    <div class="col-md-2">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-2">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
