<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Category
};

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

    <?php if ($priceRange && $priceRange['min']['default'] != $priceRange['max']['default']) { ?>
        <div class="one-filter filter-range-slider">
            <?= Html::a(
                Yii::t('app', 'Цена'),
                'javascript:void(0);',
                ['class' => 'filt-but']
            ) ?>
            <div class="price-slider-cont">
                <div id="price-slider" class="myarredo-slider"
                     data-min="<?= $priceRange['min']['current'] ?>"
                     data-max="<?= $priceRange['max']['current'] ?>"></div>
                <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
                    <div class="cur min">
                        <?= Html::input(
                            'text',
                            'price[min]',
                            $priceRange['min']['default'],
                            ['id' => 'min-price', 'data-default' => $priceRange['min']['default']]
                        ) ?>
                        <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                    </div>
                    <span class="indent"> - </span>
                    <div class="cur max">
                        <?= Html::input(
                            'text',
                            'price[max]',
                            $priceRange['max']['default'],
                            ['id' => 'max-price', 'data-default' => $priceRange['max']['default']]
                        ) ?>
                        <span class="for-curicon"><?= Yii::$app->currency->symbol ?></span>
                    </div>
                </div>
                <?= Html::input('hidden', 'price[link]', $priceRange['link']) ?>
                <a href="javascript:void(0);" class="submit submit_price">OK</a>
            </div>
        </div>
    <?php } ?>

    <?= Html::hiddenInput('sort', Yii::$app->request->get('sort') ?? null) ?>
    <?= Html::hiddenInput('object', Yii::$app->request->get('object') ?? null) ?>

    <?php ActiveForm::end() ?>

</div>

