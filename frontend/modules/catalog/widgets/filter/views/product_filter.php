<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Category;

/** @var $route string */
/** @var $category Category */
/** @var $types [] */
/** @var $subtypes [] */
/** @var $style [] */
/** @var $factory [] */
/** @var $collection [] */
/** @var $factory_first_show [] */
/** @var $colors [] */
/** @var  $diameterRange [] */
/** @var  $widthRange [] */
/** @var  $lengthRange [] */
/** @var  $heightRange [] */
/** @var  $apportionmentRange [] */
/** @var  $sizesLink string */
/** @var $priceRange [] */

?>

    <div class="filters">

        <?php
        $form = ActiveForm::begin([
            'method' => 'get',
            'id' => 'catalog_filter',
            'action' => Url::toRoute([$route])
        ]); ?>

        <div class="one-filter">
            <?= Html::a(
                Yii::t('app', 'Category'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">
                <?php foreach ($category as $item) {
                    $options = $item['checked']
                        ? ['class' => 'one-item selected']
                        : ['class' => 'one-item'];
                    echo Html::a(
                        Html::img(
                            Category::getImage($item['image_link3'])
                        ) . $item['title'] . '<span>' . $item['count'] . '</span>',
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
                    <?php foreach ($types as $item) {
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

        <?php if (YII_DEBUG) { ?>
            <div id="filter-sizes" class="one-filter filter-range-slider">
                <?= Html::a(
                    Yii::t('app', 'Размеры'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="price-slider-cont">

                    <?php if ($diameterRange && $diameterRange['min']['default'] != $diameterRange['max']['default']) { ?>
                        <span class="for-filter-text"><?= Yii::t('app', 'Диаметр') ?></span>
                        <div class="myarredo-slider" data-min="<?= $diameterRange['min']['current'] ?>"
                             data-max="<?= $diameterRange['max']['current'] ?>"></div>
                        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                            <div class="cur min">
                                <?= Html::input(
                                    'text',
                                    'diameter[min]',
                                    $diameterRange['min']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                            <span class="indent"> - </span>
                            <div class="cur max">
                                <?= Html::input(
                                    'text',
                                    'diameter[max]',
                                    $diameterRange['max']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($widthRange && $widthRange['min']['default'] != $widthRange['max']['default']) { ?>
                        <span class="for-filter-text"><?= Yii::t('app', 'Ширина') ?></span>
                        <div class="myarredo-slider" data-min="<?= $widthRange['min']['current'] ?>"
                             data-max="<?= $widthRange['max']['current'] ?>"></div>
                        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                            <div class="cur min">
                                <?= Html::input(
                                    'text',
                                    'width[min]',
                                    $widthRange['min']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                            <span class="indent"> - </span>
                            <div class="cur max">
                                <?= Html::input(
                                    'text',
                                    'width[max]',
                                    $widthRange['max']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($lengthRange && $lengthRange['min']['default'] != $lengthRange['max']['default']) { ?>
                        <span class="for-filter-text"><?= Yii::t('app', 'Длина') ?></span>
                        <div class="myarredo-slider" data-min="<?= $lengthRange['min']['current'] ?>"
                             data-max="<?= $lengthRange['max']['current'] ?>"></div>
                        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                            <div class="cur min">
                                <?= Html::input(
                                    'text',
                                    'length[min]',
                                    $lengthRange['min']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                            <span class="indent"> - </span>
                            <div class="cur max">
                                <?= Html::input(
                                    'text',
                                    'length[max]',
                                    $lengthRange['max']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($heightRange && $heightRange['min']['default'] != $heightRange['max']['default']) { ?>
                        <span class="for-filter-text"><?= Yii::t('app', 'Высота') ?></span>
                        <div class="myarredo-slider" data-min="<?= $heightRange['min']['current'] ?>"
                             data-max="<?= $heightRange['max']['current'] ?>"></div>
                        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                            <div class="cur min">
                                <?= Html::input(
                                    'text',
                                    'height[min]',
                                    $heightRange['min']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                            <span class="indent"> - </span>
                            <div class="cur max">
                                <?= Html::input(
                                    'text',
                                    'height[max]',
                                    $heightRange['max']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($apportionmentRange && $apportionmentRange['min']['default'] != $apportionmentRange['max']['default']) { ?>
                        <span class="for-filter-text"><?= Yii::t('app', 'Раскладка') ?></span>
                        <div class="myarredo-slider" data-min="<?= $apportionmentRange['min']['current'] ?>"
                             data-max="<?= $apportionmentRange['max']['current'] ?>"></div>
                        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                            <div class="cur min">
                                <?= Html::input(
                                    'text',
                                    'apportionment[min]',
                                    $apportionmentRange['min']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                            <span class="indent"> - </span>
                            <div class="cur max">
                                <?= Html::input(
                                    'text',
                                    'apportionment[max]',
                                    $apportionmentRange['max']['default']
                                ) ?>
                                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
                            </div>
                        </div>
                    <?php } ?>

                    <?= Html::input('hidden', 'sizesLink', $sizesLink) ?>

                    <a href="javascript:void(0);" class="submit submit_sizes">OK</a>
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
                    <?php foreach ($style as $item) {
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

        <?php if ($factory) { ?>
            <div class="one-filter">
                <?= Html::a(
                    Yii::t('app', 'Фабрики'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">

                    <?php foreach ($factory_first_show as $key => $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
                    } ?>

                    <?php if (count($factory) > count($factory_first_show)) {
                        echo Html::a(
                            '<span class="btn-text">' . Yii::t('app', 'Показать еще') . '</span>',
                            'javascript:void(0);',
                            [
                                'class' => 'show-more show-class',
                                'data-toggle' => 'modal',
                                'data-target' => '#factory-modal',
                            ]
                        );
                    } ?>

                    <div id="factory-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <?= Yii::t('app', 'Close') ?>
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h3 class="text-center">
                                    <?= Yii::t('app', 'Выбор фабрики') ?>
                                </h3>
                                <div class="alphabet-tab">
                                    <?php foreach ($factory as $letter => $val) {
                                        echo Html::a($letter, "javascript:void(0);");
                                    } ?>
                                </div>
                                <div class="alphabet-tab-cont">
                                    <?php foreach ($factory as $letter => $val) { ?>
                                        <div data-show="<?= $letter ?>">
                                            <?php foreach ($val as $item) {
                                                $class = $item['checked']
                                                    ? 'one-item-check selected'
                                                    : 'one-item-check';

                                                echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                                                ?>
                                                <div class="my-checkbox"></div><?= $item['title'] ?> (<?= $item['count'] ?>)
                                                <?php
                                                echo Html::endTag('a');
                                            } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($collection) { ?>
            <div class="one-filter open">
                <?= Html::a(
                    Yii::t('app', 'Коллекция'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="list-item">
                    <?php foreach ($collection as $item) {
                        $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                        echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class]);
                        ?>
                        <div class="filter-group">
                            <div class="my-checkbox"></div><?= $item['title'] ?>
                        </div>
                        <span><?= $item['count'] ?></span>
                        <?php
                        echo Html::endTag('a');
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

        <?php if ($priceRange && $priceRange['min']['default'] != $priceRange['max']['default']) { ?>
            <div class="one-filter filter-range-slider">
                <?= Html::a(
                    Yii::t('app', 'Цена'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="price-slider-cont">
                    <div class="myarredo-slider"
                         data-min="<?= $priceRange['min']['current'] ?>"
                         data-max="<?= $priceRange['max']['current'] ?>"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input('text', 'price[min]', $priceRange['min']['default']) ?>
                            <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
                            <?= Html::input('text', 'price[max]', $priceRange['max']['default']) ?>
                            <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                        </div>
                    </div>
                    <?= Html::input('hidden', 'price[link]', $priceRange['link']) ?>
                    <a href="javascript:void(0);" class="submit submit_price">OK</a>
                </div>
            </div>
        <?php } ?>

        <?php
        echo Html::hiddenInput('sort', Yii::$app->request->get('sort') ?? null);
        echo Html::hiddenInput('object', Yii::$app->request->get('object') ?? null);

        if (count(Yii::$app->catalogFilter->params) >= 1) {
            echo Html::a(
                Yii::t('app', 'Сбросить фильтры'),
                Url::toRoute([$route]),
                [
                    'class' => 'reset',
                    'rel' => 'nofollow'
                ]
            );
        }

        ActiveForm::end();
        ?>

    </div>

<?php
$script = <<<JS
$('.submit_sizes').on('click', function () {
    let link = $('input[name="sizesLink"]').val(),
    diameterMin = $('input[name="diameter[min]"]'),
    diameterMax = $('input[name="diameter[max]"]'),
    widthMin = $('input[name="width[min]"]'),
    widthMax = $('input[name="width[max]"]'),
    lengthMin = $('input[name="length[min]"]'),
    lengthMax = $('input[name="length[max]"]'),
    heightMin = $('input[name="height[min]"]'),
    heightMax = $('input[name="height[max]"]'),
    apportionmentMin = $('input[name="apportionment[min]"]'),
    apportionmentMax = $('input[name="apportionment[max]"]');

    if (diameterMin.length && diameterMax.length) {
        link = link.replace('{diameterMin}', diameterMin.val());
        link = link.replace('{diameterMax}', diameterMax.val());   
    }

    if (widthMin.length && widthMax.length) {
        link = link.replace('{widthMin}', widthMin.val());
        link = link.replace('{widthMax}', widthMax.val());   
    }
     
    if (lengthMin.length && lengthMax.length) {
        link = link.replace('{lengthMin}', lengthMin.val());
        link = link.replace('{lengthMax}', lengthMax.val());   
    }
    
    if (heightMin.length && heightMax.length) {
        link = link.replace('{heightMin}', heightMin.val());
        link = link.replace('{heightMax}', heightMax.val());   
    }
    
    if (apportionmentMin.length && apportionmentMax.length) {
        link = link.replace('{apportionmentMin}', apportionmentMin.val());
        link = link.replace('{apportionmentMax}', apportionmentMax.val());   
    }

    window.location.href = link;
});

$('.submit_price').on('click', function () {
    let link = $('input[name="price[link]"]').val(),
        min = $('input[name="price[min]"]').val(),
        max = $('input[name="price[max]"]').val();
    
    link = link.replace('{priceMin}', min);
    link = link.replace('{priceMax}', max);

    window.location.href = link;
});

$('.category-filter label').on('click', function () {
    let checkbox = $(this).parent().find('input[type=checkbox]');  
   
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
