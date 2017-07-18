<?php

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line($model, 'alias') ?>

<?= $form->text_line($model, 'article') ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line($model, 'factory_id') ?>

<?= $form->text_line($model, 'collections_id') ?>

<?= $form->text_line($model, 'catalog_type_id') ?>

<?= $form->text_line($model, 'catalogGroups') ?>

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
    <div class="col-md-3">

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
