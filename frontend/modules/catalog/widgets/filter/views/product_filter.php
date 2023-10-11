<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/** @var $filterParams [] */
/** @var $keys [] */
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
/** @var $producing_country [] */

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
                    $options = [];
                    $options['href'] = $item['link'];
                    $options['class'] = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                    if (isset($filterParams[$keys['type']]) && count($filterParams[$keys['type']]) >= 1 && $item['checked'] == 0) {
                        $options['rel'] = 'nofollow';
                    }

                    echo Html::beginTag('a', $options);
                    ?>
                    <div class="filter-group">
                        <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                    <?php
                    echo Html::endTag('a');
                } ?>
            </div>
        </div>
    <?php } ?>


    <div class="one-filter">
        <?php if ($subtypes) { ?>
            <?= Html::a(
                Yii::t('app', 'Тип'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">
                <?php foreach ($subtypes as $item) {
                    $options = [];
                    $options['href'] = $item['link'];
                    $options['class'] = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                    if (isset($filterParams[$keys['subtypes']]) && count($filterParams[$keys['subtypes']]) >= 1 && $item['checked'] == 0) {
                        $options['rel'] = 'nofollow';
                    }

                    echo Html::beginTag('a', $options);
                    ?>
                    <div class="filter-group">
                        <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                    <?php
                    echo Html::endTag('a');
                } ?>
            </div>
        <?php } ?>
    </div>


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
                        <?= Html::input('text', 'price[min]', $priceRange['min']['default'], ['data-default' => $priceRange['min']['default']]) ?>
                        <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                    </div>
                    <span class="indent"> - </span>
                    <div class="cur max">
                        <?= Html::input('text', 'price[max]', $priceRange['max']['default'], ['data-default' => $priceRange['max']['default']]) ?>
                        <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                    </div>
                </div>
                <?= Html::input('hidden', 'price[link]', $priceRange['link']) ?>
                <a href="javascript:void(0);" class="submit submit_price" rel="nofollow">OK</a>
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
                    $options = [];
                    $options['href'] = $item['link'];
                    $options['class'] = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                    if (isset($filterParams[$keys['style']]) && count($filterParams[$keys['style']]) >= 1 && $item['checked'] == 0) {
                        $options['rel'] = 'nofollow';
                    }

                    echo Html::beginTag('a', $options);
                    ?>
                    <div class="filter-group">
                        <div class="my-checkbox"></div><?= $item['title'] ?></div><span><?= $item['count'] ?></span>
                    <?php
                    echo Html::endTag('a');
                } ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($producing_country) { ?>
        <div class="one-filter">
            <?= Html::a(
                Yii::t('app', 'Producing country'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">
                <?php foreach ($producing_country as $item) {
                    $class = $item['checked'] ? 'one-item-check selected' : 'one-item-check';

                    echo Html::beginTag('a', ['href' => $item['link'], 'class' => $class, 'rel' => 'nofollow']);
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

    <?php if ($factory && !in_array(Yii::$app->controller->id, ['template-factory'])) { ?>
        <div class="one-filter">
            <?= Html::a(
                Yii::t('app', 'Фабрики'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="list-item">

                <?php foreach ($factory_first_show as $key => $item) {
                    $options = [];
                    $options['href'] = $item['link'];
                    $options['class'] = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                    if (isset($filterParams[$keys['factory']]) && count($filterParams[$keys['factory']]) >= 1 && $item['checked'] == 0) {
                        $options['rel'] = 'nofollow';
                    }

                    echo Html::beginTag('a', $options);
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
                                            $options = [];
                                            $options['href'] = $item['link'];
                                            $options['class'] = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                                            if (isset($filterParams[$keys['factory']]) && count($filterParams[$keys['factory']]) >= 1 && $item['checked'] == 0) {
                                                $options['rel'] = 'nofollow';
                                            }

                                            echo Html::beginTag('a', $options);
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
                    $options = [];
                    $options['href'] = $item['link'];
                    $options['class'] = $item['checked'] ? 'one-item-check selected' : 'one-item-check';
                    if (isset($filterParams[$keys['colors']]) && count($filterParams[$keys['colors']]) >= 1 && $item['checked'] == 0) {
                        $options['rel'] = 'nofollow';
                    }

                    echo Html::beginTag('a', $options);
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
