<?php

use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use backend\modules\catalog\models\{
    Category, Factory, Collection, Types, SubTypes
};

/**
 * @var $model Product
 * @var $modelLang ProductLang
 * @var $form ActiveForm
 */

?>

<?= $form->text_line($model, 'alias') ?>

<?= $form->text_line($model, 'alias_en') ?>

<?= $form->text_line($model, 'alias_it') ?>

<?= $form->text_line($model, 'alias_de') ?>

<?= $form->text_line($model, 'alias_he') ?>

<?= $form->text_line($model, 'article') ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
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

$this->registerJs($script);
?>

<p>
    Коллекция напрямую зависит от выбранной фабрики.<br>
    Если по выбраной фабрики отсутсвует необходимая Коллекция, зайдите в редактирование
    фабрики и добавте зависимость с фабрикой.
</p>

<?= $form
    ->field($model, 'collections_id')
    ->widget(Select2::class, [
        'data' => Collection::dropDownList(['factory_id' => $model->isNewRecord ? 0 : $model['factory_id']]),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form
            ->field($model, 'catalog_type_id')
            ->label(Yii::t('app', 'Предмет'))
            ->widget(Select2::class, [
                'data' => Types::dropDownList(),
                'options' => ['placeholder' => Yii::t('app', 'Select option')],
            ]) ?>
    </div>
    <div class="col-md-9">
        <?= $form
            ->field($model, 'subtypes_ids')
            ->widget(Select2::class, [
                'data' => SubTypes::dropDownList(['parent_id' => $model->isNewRecord ? -1 : $model['catalog_type_id']]),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]) ?>
    </div>
</div>


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
        
        var subtypes = '';
        $.each(data.subtypes, function( key, value ) {
           subtypes += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#product-subtypes_ids').html(subtypes);
    });
});
JS;

$this->registerJs($script);
?>

<p>
    Категории напрямую зависит от выбранного типа предмета.<br>
    Если по выбраному типу предмета отсутсвует необходимая категория, зайдите в редактирование
    категории и добавте зависимость с предметом.
</p>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::class, [
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
    <div class="col-md-3">
        <?= $form->field($model, 'currency')->dropDownList($model::currencyRange(), ['disabled' => true]); ?>
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
        <?= $form->switcher($model, 'in_stock') ?>
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

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->field($model, 'created_at')->textInput(['disabled' => true, 'value' => date('d.m.Y H:i', $model->created_at)]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'updated_at')->textInput(['disabled' => true, 'value' => date('d.m.Y H:i', $model->updated_at)]) ?>
    </div>
</div>

<div class="row control-group">
    <?= Html::a('просмотр товара на сайте', '/product/' . $model->alias, ['target' => '_blank']); ?>
</div>
