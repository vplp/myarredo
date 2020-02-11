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
/** @var $price_range [] */

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
            <!-- Коммент беку):
            я сделал слайдер с привязкой к классу (myarredo-slider) а не к id
            поэтому все id-шники по типу этого - id="diameter-slider" - лучше удалить от греха подальше если они тебе не нужны, мне они точно не нужны
            также если тебе не нужны id-шники мин и макс полей (http://joxi.ru/52an01JCblMJMA) их я бы тоже удалил, они уже стали ненужны для js -->
            <div class="one-filter filter-range-slider">
                <?= Html::a(
                    Yii::t('app', 'Размеры'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="price-slider-cont">
                    <span class="for-filter-text">Диаметр</span> 

                    <div id="diameter-slider" class="myarredo-slider" data-min="50" data-max="250"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input(
                                'text',
                                'diameter[min]',
                                50,
                                ['id' => 'min-diameter']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
                            <?= Html::input(
                                'text',
                                'diameter[max]',
                                250,
                                ['id' => 'max-diameter']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                    </div>

                    <span class="for-filter-text">Ширина</span>
                    <div id="width-slider" class="myarredo-slider" data-min="40" data-max="130"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input(
                                'text',
                                'width[min]',
                                40,
                                ['id' => 'min-width']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
                            <?= Html::input(
                                'text',
                                'width[max]',
                                130,
                                ['id' => 'max-width']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                    </div>
                    <span class="for-filter-text">Длина</span>
                    <div id="length-slider" class="myarredo-slider" data-min="90" data-max="300"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input(
                                'text',
                                'length[min]',
                                90,
                                ['id' => 'min-length']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
                            <?= Html::input(
                                'text',
                                'length[max]',
                                300,
                                ['id' => 'max-length']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                    </div>
                    <span class="for-filter-text">Высота</span>
                    <div id="height-slider" class="myarredo-slider" data-min="45" data-max="355"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input(
                                'text',
                                'height[min]',
                                45,
                                ['id' => 'min-height']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
                            <?= Html::input(
                                'text',
                                'height[max]',
                                355,
                                ['id' => 'max-height']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                    </div>
                    <span class="for-filter-text">Раскладка</span>
                    <div id="apportionment-slider" class="myarredo-slider" data-min="35" data-max="270"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input(
                                'text',
                                'apportionment[min]',
                                35,
                                ['id' => 'min-apportionment']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
                            <?= Html::input(
                                'text',
                                'apportionment[max]',
                                270,
                                ['id' => 'max-apportionment']
                            ) ?>
                            <span class="for-curicon">см</span>
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="submit">OK</a>
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

        <?php if ($price_range && $price_range['min']['default'] != $price_range['max']['default']) { ?>
            <div class="one-filter filter-range-slider">
                <?= Html::a(
                    Yii::t('app', 'Цена'),
                    'javascript:void(0);',
                    ['class' => 'filt-but']
                ) ?>
                <div class="price-slider-cont">
                    <div id="price-slider" class="myarredo-slider"
                         data-min="<?= $price_range['min']['current'] ?>"
                         data-max="<?= $price_range['max']['current'] ?>"></div>
                    <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                        <div class="cur min">
                            <?= Html::input(
                                'text',
                                'price[min]',
                                $price_range['min']['default'],
                                ['id' => 'min-price']
                            ) ?>
                            <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                        </div>
                        <span class="indent"> - </span>
                        <div class="cur max">
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
