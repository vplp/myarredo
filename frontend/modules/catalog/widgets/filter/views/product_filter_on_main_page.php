<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => false
]) ?>

    <div class="filter-title">
        Портал проверенных поставщиков
        итальянской мебели
        <div class="frosted-glass"></div>
    </div>

    <div class="filter-bot">

        <?= Html::dropDownList(
            'category',
            '',
            ['' => 'Категория'] + $category,
            [
                'id' => 'filter_by_category',
                'class' => 'first',
                'data-styler' => true
            ]
        ); ?>

        <?= Html::dropDownList(
            'types',
            '',
            ['' => 'Предмет'] + $types,
            [
                'id' => 'filter_by_types',
                'class' => false,
                'data-styler' => true,
            ]
        ); ?>

        <div class="filter-price">
            <div class="left">
                <input type="text" placeholder="от">
                <input type="text" placeholder="до">
                €
            </div>

            <?= Html::submitButton('Найти', [
                'class' => 'search',
                'name' => 'filter_on_main_page',
                'value' => 1
            ]) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>

<?php
$script = <<<JS
$('select#filter_by_category').change(function(){
    var id = parseInt($(this).val());
    $.post('/location/location/get-cities/', {_csrf: $('#token').val(),types_id:id}, function(data){
        var select = $('select#filter_by_category');
        select.html(data.options);
        select.trigger('refresh');
    });
});
$('select#filter_by_types').change(function(){
    var id = parseInt($(this).val());
    $.post('/location/location/get-cities/', {_csrf: $('#token').val(),types_id:id}, function(data){
        var select = $('select#filter_by_types');
        select.html(data.options);
        select.trigger('refresh');
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
