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
        <?= Yii::t('app', 'Портал проверенных поставщиков итальянской мебели') ?>
        <div class="frosted-glass"></div>
    </div>

    <div class="filter-bot">

        <?= Html::dropDownList(
            'category',
            '',
            ['' => Yii::t('app', 'Category')] + $category,
            [
                'id' => 'filter_by_category',
                'class' => 'first',
                'data-styler' => true
            ]
        ); ?>

        <?= Html::dropDownList(
            'types',
            '',
            ['' => Yii::t('app', 'Предмет')] + $types,
            [
                'id' => 'filter_by_types',
                'class' => false,
                'data-styler' => true,
            ]
        ); ?>

        <div class="filter-price">
            <div class="left">
                <input type="text" name="price[from]" placeholder="<?= Yii::t('app', 'от') ?>">
                <input type="text" name="price[to]" placeholder="<?= Yii::t('app', 'до') ?>">
                €
            </div>

            <?= Html::submitButton(
                Yii::t('app', 'Найти'),
                [
                    'class' => 'search',
                    'name' => 'filter_on_main_page',
                    'value' => 1,
                    'rel' => 'nofollow'
                ]
            ) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>

<?php

$ajax_get_types = Url::to(['/catalog/category/ajax-get-types']);
$ajax_get_category = Url::to(['/catalog/category/ajax-get-category']);

$script = <<<JS
$('select#filter_by_category').change(function(){
    var category_alias = $(this).val();
    var type_alias = $('select#filter_by_types option:selected').val();
    
    $.post('$ajax_get_types', {_csrf: $('#token').val(),category_alias:category_alias}, function(data){
        var select = $('select#filter_by_types');
        select.html(data.options);
        $('select#filter_by_types').val(type_alias);
        select.trigger('refresh');
    });
});

$('select#filter_by_types').change(function(){
    var category_alias = $('select#filter_by_category option:selected').val();
    var type_alias = $(this).val();
     console.log(category_alias);
    
    $.post('$ajax_get_category', {_csrf: $('#token').val(),type_alias:type_alias}, function(data){
        var select = $('select#filter_by_category');
        select.html(data.options);
        $('select#filter_by_category').val(category_alias);
        select.trigger('refresh');
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);