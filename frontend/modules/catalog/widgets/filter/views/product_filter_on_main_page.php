<?php

use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 */

?>

    <div class="filter"></div>

<?php
$description = $model['lang']['description'] ?? '';
$url = Url::to(['/catalog/category/ajax-get-filter-on-main']);
$ajax_get_types = Url::to(['/catalog/category/ajax-get-types']);
$ajax_get_category = Url::to(['/catalog/category/ajax-get-category']);

$script = <<<JS
$.post('$url', {_csrf: $('#token').val()}, function(data){
    $('.filter').html(data.html);

    if ('$description' != '') {
        $('.filter-title div').eq(0).html('$description');
    }
    
    setTimeout(function() {
        $('[data-styler]').styler();
    }, 100);
    
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
        
        $.post('$ajax_get_category', {_csrf: $('#token').val(),type_alias:type_alias}, function(data){
            var select = $('select#filter_by_category');
            select.html(data.options);
            $('select#filter_by_category').val(category_alias);
            select.trigger('refresh');
        });
    });        
});
JS;

$this->registerJs($script);
