<?php

use kartik\widgets\Select2;
//
use backend\app\bootstrap\ActiveForm;
use backend\modules\location\models\City;
use backend\modules\catalog\models\Category;
use backend\modules\banner\models\{
    BannerItemCatalog, BannerItemLang
};

/**
 * @var $model BannerItemCatalog
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
 */

?>

<?= $form->field($model, 'type')->hiddenInput(['value' => 'catalog'])->label(false) ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line_lang($modelLang, 'description') ?>

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

<?= $form
    ->field($model, 'categories_ids')
    ->widget(Select2::class, [
        'data' => Category::dropDownList(),
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
