<?php

use kartik\widgets\Select2;
use backend\modules\location\models\{
    Country, City
};
use backend\modules\catalog\models\{
    Category, Factory, Types, SubTypes
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $form ActiveForm
 * @var $model Sale $model
 * @var $modelLang SaleLang
 */

$url = \yii\helpers\Url::toRoute('/location/city/get-cities');

$script = <<<JS
$('select#profile-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#profile-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});

JS;

$this->registerJs($script);

?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line($model, 'phone') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
        'data' => Factory::dropDownList(),
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

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->field($model, 'country_id')
            ->selectOne([0 => '--'] + Country::dropDownList()) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'city_id')
            ->selectOne([0 => '--'] + City::dropDownList($model->country_id)) ?>
    </div>
</div>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/product/ajax-get-category');
$script = <<<JS
$('#sale-catalog_type_id').on('change', function () {
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
        $('#sale-category_ids').html(category);
        
        var subtypes = '';
        $.each(data.subtypes, function( key, value ) {
           subtypes += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#sale-subtypes_ids').html(subtypes);        
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

<?= $form->text_line($model, 'factory_name') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'price') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'price_new') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'currency')->dropDownList($model::currencyRange()); ?>
    </div>
</div>

<?= $form->text_line($model, 'country_code') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'on_main') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'is_sold') ?>
    </div>
</div>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
