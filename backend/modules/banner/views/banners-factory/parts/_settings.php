<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\Factory;
use backend\modules\banner\models\{
    BannerItem, BannerItemLang
};
use kartik\widgets\Select2;

/**
 * @var $model BannerItem
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

?>

<?= $form->field($model, 'type')->hiddenInput(['value' => 'factory'])->label(false) ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line_lang($modelLang, 'description') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?= $form->text_line_lang($modelLang, 'link') ?>

<div class="row control-group">
    <div class="col-md-2">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-2">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
