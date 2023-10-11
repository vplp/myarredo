<?php

use yii\helpers\{
    Html, ArrayHelper
};
use kartik\widgets\Select2;
use backend\modules\catalog\models\{
    Factory, Types
};
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Composition, CompositionLang
};

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $modelLang CompositionLang
 */

?>

<?= Html::label(Yii::t('app', 'Factory')) ?>
<?= Select2::widget([
    'name' => 'factoryF',
    'data' => Factory::dropDownList(),
    'options' => [
        'placeholder' => Yii::t('app', 'Select option'),
        'id' => 'factoryF',
        'class' => 'selectFilter',
    ],
]); ?>

<?= Html::label(Yii::t('app', 'Collections')) ?>
<?= Select2::widget([
    'name' => 'collectionF',
    'data' => [],
    'options' => [
        'placeholder' => Yii::t('app', 'Select option'),
        'id' => 'collectionF',
        'class' => 'selectFilter',
    ],
]); ?>

<?= Html::label(Yii::t('app', 'Type')) ?>
<?= Select2::widget([
    'name' => 'typeF',
    'data' => Types::dropDownList(['parent_id' => 0]),
    'options' => [
        'placeholder' => Yii::t('app', 'Select option'),
        'id' => 'typeF',
        'class' => 'selectFilter',
    ],
]); ?>


<?= Html::label(Yii::t('app', 'Category')) ?>
<?= Select2::widget([
    'name' => 'catalogF',
    'data' => [],
    'options' => [
        'placeholder' => Yii::t('app', 'Select option'),
        'id' => 'catalogF',
        'class' => 'selectFilter',
    ],
]); ?>

<?= $form
    ->field($model, 'product_ids')
    ->widget(Select2::class, [
        'data' => ArrayHelper::map($model->product, 'id', function ($item) {
            return  '[' . $item['article'] . '] ' . $item['lang']['title'];
        }),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true,
            'class' => 'multiselect',
        ],
    ]) ?>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/compositions/ajax-get-products');
$script = <<<JS
$('.selectFilter').on('change', function (e) {
    
    var elem = $(e.target)
        , selects = $('.selectFilter option:selected')
        , selectedArray = {} // вибрані елементи селектів
        , selected_val_tovars = [] // вибрані товари
        , elem_tovars = $("#composition-product_ids option:selected");

    for (var i = 0, n = elem_tovars.length; i < n; i++) { 
        if (elem_tovars[i].value) {
            selected_val_tovars.push(elem_tovars[i].value);
        }
    }
                    
    selects.each(function (k, e) {
        selectedArray[$(e).parent().attr('id')] = $(e).val();
    });

    $.ajax({
        url: '$url',
        type: 'post',
        dataType: 'json',
        data: {
            _csrf: $('#token').val(),
            selectedArray: selectedArray,
            selected_val_tovars: selected_val_tovars,
            change: elem.attr('id')
        },
        success: function (data) {
            // category
            if (typeof (data.category) !== 'undefined' && data.category.length !== 0) {
                var category = '<option value="0">Выберите вариант</option>';
                $.each(data.category, function(key, value) {
                    category += '<option value="'+ key +'">' + value + '</option>';
                });
                $('#catalogF').html(category);
            }
            
            // types
            if (typeof (data.types) !== 'undefined' && data.types.length !== 0) {
                var types = '<option value="0">Выберите вариант</option>';
                $.each(data.types, function(key, value) {
                    types += '<option value="'+ key +'">' + value + '</option>';
                });
                $('#typeF').html(types);
            }
            
            // collection
            if (typeof (data.collection) !== 'undefined' && data.collection.length !== 0) {
                var collection = '<option value="0">Выберите вариант</option>';
                $.each(data.collection, function(key, value) {
                    collection += '<option value="'+ key +'">' + value + '</option>';
                });
                $('#collectionF').html(collection);
            }
           
            // tovars
            if (typeof (data.tovars) !== 'undefined') {
                var tovars = '';               
                $.each(data.tovars, function(key, value) {               
                    var selected = (selected_val_tovars.includes(key)) ? 'selected' : '';
                    tovars += '<option ' + selected + ' value="'+ key +'">' + value + '</option>';
                });
                $("#composition-product_ids").html(tovars);
            }
        }
    });
});
JS;

$this->registerJs($script);
?>
