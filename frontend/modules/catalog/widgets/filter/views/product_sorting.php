<?php

use yii\helpers\Html;

?>

<div class="location-buts flex">
    <a href="javascript:void(0);" data-style="small" class="tiles4 flex active">
        <i></i><i></i><i></i><i></i>
        <i></i><i></i><i></i><i></i>
    </a>
    <a href="javascript:void(0);" data-style="large" class="tiles2 flex">
        <i></i><i></i>
    </a>
</div>

<div class="sort-by">
    Сортировать по цене:
    <?= Html::dropDownList(
        'sort',
        Yii::$app->request->get('sort'),
        $sortList,
        ['class' => 'selectpicker']
    ); ?>
</div>

<div class="sort-by">
    Показать:
    <?= Html::dropDownList(
        'object',
        Yii::$app->request->get('object'),
        $objectList,
        ['class' => 'selectpicker']
    ); ?>
</div>

<?php
//$script = <<<JS
//$('.sort-by').on('change', function () {
//    var value = $(this).find('option:selected').val(),
//        name = $(this).find('select').attr('name');
//    $('#catalog_filter').find('input[name=' + name + ']').val(value);
//    $('#catalog_filter').submit();
//});
//JS;
//
//$this->registerJs($script, yii\web\View::POS_READY);
?>