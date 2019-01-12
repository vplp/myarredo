<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?= Html::beginTag('a', [
    'href' => Product::getUrl($model['alias']),
    'class' => 'one-prod-tile'
]); ?>
    <div class="one-prod-tile-in" itemscope itemtype="http://schema.org/ImageObject">

        <?php
        /*
        if (!$model['removed']): ?>
                <object>
                    <div class="request-price" data-id=<?= $model['id'] ?> data-toggle="modal" data-target="#myModal">
                        Запросить цену
                    </div>
                </object>
            <?php endif;
        */
        ?>

        <div class="img-cont" data-dominant-color>
            <span class="background"></span>
            <?= Html::img(
                Product::getImageThumb($model['image_link']),
                [
                    'alt' => Product::getStaticTitle($model),
                    'itemprop' => 'contentUrl'
                ]
            ) ?>
        </div>

        <div class="prod-infoblock">
            <div class="tile-brand">
                <?= (isset($factory[$model['factory_id']]))
                    ? $factory[$model['factory_id']]['title']
                    : null;
                ?>
            </div>
            <div class="tile-prod-name" itemprop="name">
                <?= Product::getStaticTitle($model); ?>
            </div>
        </div>

        <?php if (!$model['removed'] && $model['price_from'] > 0) { ?>
            <div class="">
                <?= Yii::t('app', 'Цена от') ?>:
                <span><?= $model['price_from']; ?> <span class="currency">€</span></span>
            </div>
        <?php } ?>

        <object class="btn-block">
            <a class="more-info">
                <?= Yii::t('app', 'Подробнее') ?>
            </a>

            <!--
            <a href="javascript:void(0);" class="get-price">
                запросить цену
            </a>
            -->
        </object>
    </div>

<?= Html::endTag('a'); ?>