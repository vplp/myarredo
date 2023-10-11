<?php

use yii\helpers\{
    Html, Url
};

/** @var $route string */
/** @var  $diameterRange [] */
/** @var  $widthRange [] */
/** @var  $lengthRange [] */
/** @var  $heightRange [] */
/** @var  $apportionmentRange [] */
/** @var  $sizesLink string */

?>


<?= Html::a(
    Yii::t('app', 'Размеры'),
    'javascript:void(0);',
    ['class' => 'filt-but']
) ?>
<div class="price-slider-cont">
    <?php if (isset($widthRange['min']) && isset($widthRange['max']) && $widthRange['min']['default'] != $widthRange['max']['default']) { ?>
        <span class="for-filter-text"><?= Yii::t('app', 'Ширина') ?></span>
        <div class="myarredo-slider" data-min="<?= $widthRange['min']['current'] ?>"
             data-max="<?= $widthRange['max']['current'] ?>"></div>
        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
            <div class="cur min">
                <?= Html::input(
                    'text',
                    'width[min]',
                    $widthRange['min']['default'],
                    ['data-default' => $widthRange['min']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
            <span class="indent"> - </span>
            <div class="cur max">
                <?= Html::input(
                    'text',
                    'width[max]',
                    $widthRange['max']['default'],
                    ['data-default' => $widthRange['max']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($heightRange['min']) && isset($heightRange['max']) && $heightRange['min']['default'] != $heightRange['max']['default']) { ?>
        <span class="for-filter-text"><?= Yii::t('app', 'Высота') ?></span>
        <div class="myarredo-slider" data-min="<?= $heightRange['min']['current'] ?>"
             data-max="<?= $heightRange['max']['current'] ?>"></div>
        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
            <div class="cur min">
                <?= Html::input(
                    'text',
                    'height[min]',
                    $heightRange['min']['default'],
                    ['data-default' => $heightRange['min']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
            <span class="indent"> - </span>
            <div class="cur max">
                <?= Html::input(
                    'text',
                    'height[max]',
                    $heightRange['max']['default'],
                    ['data-default' => $heightRange['max']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($lengthRange['min']) && isset($lengthRange['max']) && $lengthRange['min']['default'] != $lengthRange['max']['default']) { ?>
        <span class="for-filter-text"><?= Yii::t('app', 'Длина') ?></span>
        <div class="myarredo-slider" data-min="<?= $lengthRange['min']['current'] ?>"
             data-max="<?= $lengthRange['max']['current'] ?>"></div>
        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
            <div class="cur min">
                <?= Html::input(
                    'text',
                    'length[min]',
                    $lengthRange['min']['default'],
                    ['data-default' => $lengthRange['min']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
            <span class="indent"> - </span>
            <div class="cur max">
                <?= Html::input(
                    'text',
                    'length[max]',
                    $lengthRange['max']['default'],
                    ['data-default' => $lengthRange['max']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($diameterRange['min']) && isset($diameterRange['max']) && $diameterRange['min']['default'] != $diameterRange['max']['default']) { ?>
        <span class="for-filter-text"><?= Yii::t('app', 'Диаметр') ?></span>
        <div class="myarredo-slider" data-min="<?= $diameterRange['min']['current'] ?>"
             data-max="<?= $diameterRange['max']['current'] ?>"></div>
        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
            <div class="cur min">
                <?= Html::input(
                    'text',
                    'diameter[min]',
                    $diameterRange['min']['default'],
                    ['data-default' => $diameterRange['min']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
            <span class="indent"> - </span>
            <div class="cur max">
                <?= Html::input(
                    'text',
                    'diameter[max]',
                    $diameterRange['max']['default'],
                    ['data-default' => $diameterRange['max']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
        </div>
    <?php } ?>

    <?php if (isset($apportionmentRange['min']) && isset($apportionmentRange['max']) && $apportionmentRange['min']['default'] != $apportionmentRange['max']['default']) { ?>
        <span class="for-filter-text"><?= Yii::t('app', 'Раскладка') ?></span>
        <div class="myarredo-slider" data-min="<?= $apportionmentRange['min']['current'] ?>"
             data-max="<?= $apportionmentRange['max']['current'] ?>"></div>
        <div class="flex s-between filter-slider-box" style="padding: 10px 0;">
            <div class="cur min">
                <?= Html::input(
                    'text',
                    'apportionment[min]',
                    $apportionmentRange['min']['default'],
                    ['data-default' => $apportionmentRange['min']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
            <span class="indent"> - </span>
            <div class="cur max">
                <?= Html::input(
                    'text',
                    'apportionment[max]',
                    $apportionmentRange['max']['default'],
                    ['data-default' => $apportionmentRange['max']['default']]
                ) ?>
                <span class="for-curicon"><?= Yii::t('app', 'см') ?></span>
            </div>
        </div>
    <?php } ?>

    <?= Html::input('hidden', 'sizesLink', $sizesLink) ?>

    <a href="javascript:void(0);" class="submit submit_sizes" rel="nofollow">OK</a>
</div>
