<?php

use backend\modules\catalog\models\{
    Factory, Collection, Types
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
    ->dropDownList(
        Factory::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose factory') . '---']
    ) ?>

<?= $form
    ->field($model, 'collections_id')
    ->dropDownList(
        Collection::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose collection') . '---']
    ) ?>

<?= $form
    ->field($model, 'catalog_type_id')
    ->dropDownList(
        Types::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose catalog type') . '---']
    ) ?>

<?= $form->text_line($model, 'catalogCategory') ?>

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
