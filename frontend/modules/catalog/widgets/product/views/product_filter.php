<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Product, Category
};

?>

<div class="filters">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'id' => 'catalog_filter',
        'action' => Url::toRoute(['/catalog/category/list'])
    ]) ?>

    <div class="one-filter open">
        <?= Html::a(
            '<i class="fa fa-times" aria-hidden="true"></i>СБРОСИТЬ ФИЛЬТРЫ',
            Url::toRoute(['/catalog/category/list']),
            ['class' => 'reset']
        ); ?>
        <a href="javascript:void(0);" class="filt-but">
            Категории
        </a>
        <div class="list-item">

            <?php foreach ($category as $item): ?>

                <?= Html::a(
                    $item['lang']['title'] /*. ' ('. $item->getProductCount().')'*/,
                    Yii::$app->catalogFilter->createUrl(['category' => $item['alias']]),
                    ['class' => 'one-item']
                ); ?>

            <?php endforeach; ?>

        </div>
    </div>

    <div class="one-filter open">
        <a href="javascript:void(0);" class="filt-but">
            Предмет
        </a>
        <div class="list-item">

            <?php foreach ($types as $item): ?>
                <div>
                    <?= Html::beginTag('a', ['href' => Yii::$app->catalogFilter->createUrl(['type' => $item['alias']]), 'class' => 'one-item-check']); ?>
                    <input type="checkbox">
                    <div class="my-checkbox"></div>
                    <?= $item['lang']['title'];//. ' ('. $item->getProductCount().')';    ?>
                    <?= Html::endTag('a'); ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="one-filter open">
        <a href="javascript:void(0);" class="filt-but">
            Стиль
        </a>
        <div class="list-item">

            <?php foreach ($style as $item): ?>
                <div>
                    <?= Html::beginTag('a', ['href' => Yii::$app->catalogFilter->createUrl(['style' => $item['alias']]), 'class' => 'one-item-check']); ?>
                    <input type="checkbox">
                    <div class="my-checkbox"></div>
                    <?= $item['lang']['title'];//. ' ('. $item->getProductCount().')';    ?>
                    <?= Html::endTag('a'); ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="one-filter open">
        <a href="javascript:void(0);" class="filt-but">
            Фабрики
        </a>
        <div class="list-item">

            <?php foreach ($factory as $item): ?>
                <div>
                    <?= Html::beginTag('a', ['href' => Yii::$app->catalogFilter->createUrl(['factory' => $item['alias']]), 'class' => 'one-item-check']); ?>
                    <input type="checkbox">
                    <div class="my-checkbox"></div>
                    <?= $item['lang']['title'];//. ' ('. $item->getProductCount().')';    ?>
                    <?= Html::endTag('a'); ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="one-filter">
        <div class="price-slider-cont">
            <a href="javascript:void(0);" class="filt-but">
                Цена
            </a>
            <div id="price-slider"></div>
            <div class="flex s-between" style="padding: 10px 0;">
                <div class="cur">
                    <input type="text" id="min-price" value="100">
                </div>
                <span class="indent"> - </span>
                <div class="cur">
                    <input type="text" id="max-price" value="10000">
                </div>
            </div>
            <a href="#" class="submit">
                OK
            </a>
        </div>
    </div>

    <?= Html::hiddenInput('sort', Yii::$app->request->get('sort') ?? null) ?>
    <?= Html::hiddenInput('object', Yii::$app->request->get('object') ?? null) ?>

    <?php ActiveForm::end() ?>

</div>

<?php
$script = <<<JS
$('.category-filter label').on('click', function () {
    var checkbox = $(this).parent().find('input[type=checkbox]');  
   
    if ($(this).parent().find('input[type=checkbox]:checked').length) {
        checkbox.prop('checked', false);
    } else {
        checkbox.prop('checked', true);
    }

    $('#catalog_filter').submit();
});
$('.category-filter input[type=checkbox]').on( "click", function () {
    $('#catalog_filter').submit();
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>
