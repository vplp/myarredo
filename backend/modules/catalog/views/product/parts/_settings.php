<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category, Factory, Collection, Types
};

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line($model, 'alias') ?>

<?= $form->text_line($model, 'article') ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::classname(), [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Choose factory')],
    ]) ?>

<?= $form
    ->field($model, 'collections_id')
    ->widget(Select2::classname(), [
        'data' => Collection::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Choose collection')],
    ]) ?>

<?= $form
    ->field($model, 'catalog_type_id')
    ->widget(Select2::classname(), [
        'data' => Types::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Choose catalog type')],
    ]) ?>

<?= $form
    ->field($model, 'category')
    ->widget(Select2::classname(), [
        'data' => Category::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Choose category'),
            'multiple' => true
        ],
    ]) ?>

<div class="row control-group">
    <div class="col-md-6">
        <?= $form->text_line($model, 'factory_price') ?>
    </div>
    <div class="col-md-6">
        <?= $form->text_line($model, 'price_from') ?>
    </div>
</div>

<?= $form->text_line($model, 'country_code') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'removed') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'popular') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'novelty') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'bestseller') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'onmain') ?>
    </div>
</div>
