<?php

use kartik\widgets\Select2;
//
use backend\app\bootstrap\ActiveForm;
use backend\modules\location\models\City;
use backend\modules\banner\models\{
    BannerItemBackground, BannerItemLang
};

/**
 * @var $model BannerItemBackground
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

?>

<?= $form->field($model, 'type')->hiddenInput(['value' => 'background'])->label(false) ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->field($model, 'side')->dropDownList($model::sideKeyRange()) ?>

<?= $form
    ->field($model, 'cities_ids')
    ->widget(Select2::class, [
        'data' => City::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]);
?>

<?= $form->text_line_lang($modelLang, 'link') ?>

<div class="row control-group">
    <div class="col-md-2">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-2">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
