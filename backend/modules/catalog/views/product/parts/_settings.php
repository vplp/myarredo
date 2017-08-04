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
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/product/ajax-get-collection');
$script = <<<JS
$('#product-factory_id').on('change', function () {
    $.post('$url',
        {
            _csrf: $('#token').val(),
            factory_id: $(this).find('option:selected').val()
        }
    ).done(function (data) {
        var collection = '';
        $.each(data.collection, function( key, value ) {
           collection += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#product-collections_id').html(collection);
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>

<p>
    Коллекция напрямую зависит от выбранной фабрики.<br>
    Если по выбраной фабрики отсутсвует необходимая Коллекция, зайдите в редактирование
    фабрики и добавте зависимость с фабрикой.
</p>

<?= $form
    ->field($model, 'collections_id')
    ->widget(Select2::classname(), [
        'data' => Collection::dropDownList(['factory_id' => $model->isNewRecord ? 0 : $model['factory_id']]),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?= $form
    ->field($model, 'catalog_type_id')
    ->widget(Select2::classname(), [
        'data' => Types::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/product/ajax-get-category');
$script = <<<JS
$('#product-catalog_type_id').on('change', function () {
    $.post('$url',
        {
            _csrf: $('#token').val(),
            type_id: $(this).find('option:selected').val()
        }
    ).done(function (data) {
        var category = '';
        $.each(data.category, function( key, value ) {
           category += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#product-category_ids').html(category);
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>

<p>
    Категории напрямую зависит от выбранного типа предмета.<br>
    Если по выбраному типу предмета отсутсвует необходимая категория, зайдите в редактирование
    категории и добавте зависимость с предметом.
</p>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::classname(), [
        'data' => Category::dropDownList(['type_id' => $model->isNewRecord ? 0 : $model['catalog_type_id']]),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'factory_price') ?>
    </div>
    <div class="col-md-3">
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
