<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Category
};

?>

    <div class="filters">

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'id' => 'catalog_filter',
            'action' => Url::toRoute([$route])
        ]) ?>

        <?php if (count(Yii::$app->catalogFilter->params) > 1) {
            echo Html::a(
                Yii::t('app', 'Сбросить фильтры'),
                Url::toRoute([$route]),
                ['class' => 'reset']
            );
        }

        if ($cities) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'City'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($cities as $item) { ?>
                        <?php $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check' ?>

                        <?= Html::beginTag('a', ['href' => $item['link'], 'class' => $class]); ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?= Html::endTag('a'); ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <div class="one-filter">
            <?= Html::a(
                Yii::t('app', 'Category'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">
                <?php foreach ($category as $item) {
                    $options = $item['checked'] ? ['class' => 'one-item selected'] : ['class' => 'one-item'];

                    echo Html::a(
                        Html::img(Category::getImage($item['image_link3'])) .
                        $item['title'] . '<span>' . $item['count'] . '</span>',
                        $item['link'],
                        $options
                    );
                } ?>
            </div>
        </div>

        <?php if ($types) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Предмет'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($types as $item) { ?>
                        <?php $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check' ?>

                        <?= Html::beginTag('a', ['href' => $item['link'], 'class' => $class]); ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?= Html::endTag('a'); ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($subtypes) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Тип'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($subtypes as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($style) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Стиль'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($style as $item) { ?>
                        <?php $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check' ?>

                        <?= Html::beginTag('a', ['href' => $item['link'], 'class' => $class]); ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?>
                        </div>
                        <span><?= $item['count'] ?></span>
                        <?= Html::endTag('a'); ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($factory) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Фабрики'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php
                    $count_factory = 0;
                    foreach ($factory as $letter => $val) {
                        foreach ($val as $item) {
                            ++$count_factory;
                            $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                            echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                            ?>
                            <div class="filter-group">
                                <div class="my-checkbox"></div><?= $item['title'] ?>
                            </div>
                            <span><?= $item['count'] ?></span>
                            <?= Html::endTag('a'); ?>
                        <?php }
                    } ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($colors) { ?>
            <div class="one-filter colors-box">
                <?= Html::a(
                    Yii::t('app', 'Color'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($colors as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"
                                 style="background-color:<?= $item['color_code'] ?>;"></div><?= $item['title'] ?>
                        </div>
                        <span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (YII_ENV_DEV && $price_range && $price_range['min']['default'] != $price_range['max']['default']) { ?>
            <div class="one-filter filter-range-slider">
                <?= Html::a(
                    Yii::t('app', 'Цена'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="price-slider-cont">
                    <div id="price-slider"
                         data-min="<?= $price_range['min']['current'] ?>"
                         data-max="<?= $price_range['max']['current'] ?>"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur">
                            <?= Html::input(
                                'text',
                                'price[min]',
                                $price_range['min']['default'],
                                ['id' => 'min-price']
                            ) ?>
                            <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur">
                            <?= Html::input(
                                'text',
                                'price[max]',
                                $price_range['max']['default'],
                                ['id' => 'max-price']
                            ) ?>
                            <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="submit">OK</a>
                </div>
            </div>
        <?php } ?>

        <?= Html::hiddenInput('sort', Yii::$app->request->get('sort') ?? null) ?>
        <?= Html::hiddenInput('object', Yii::$app->request->get('object') ?? null) ?>

        <?php ActiveForm::end() ?>

    </div>

<?php
if (!empty($price_range) && $price_range['link']) {
    $link_for_price = $price_range['link'];

    $script = <<<JS
$('.submit').on('click', function () {
    var link = '$link_for_price',
        min = $('input[name="price[min]"]').val(),
        max = $('input[name="price[max]"]').val();
    
    link = link.replace('{MIN}', min);
    link = link.replace('{MAX}', max);

    window.location.href = link;
});
JS;

    $this->registerJs($script);
}

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

$this->registerJs($script);
