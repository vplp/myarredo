<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\ItalianProduct;

/** @var $model ItalianProduct */

?>

<?= Html::beginTag('a', [
    'href' => ItalianProduct::getUrl($model['alias']),
    'class' => 'one-prod-tile',
    'target' => '_blank'
]) ?>

    <div class="one-prod-tile-in" itemscope itemtype="http://schema.org/ImageObject">

        <div class="img-cont" data-dominant-color>
            <span class="background"></span>
            <?= Html::img(
                '',
                [
                    'alt' => $model->getTitle(),
                    'itemprop' => 'contentUrl',
                    'class' => 'lazy',
                    'data-src' => ItalianProduct::getImageThumb($model['image_link'])
                ]
            ) ?>
        </div>

        <div class="item-infoblock">
            <div class="tile-brand">
                <?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name'] ?>
            </div>
            <div class="tile-prod-name" itemprop="name">
                <?= $model->getTitle() ?>
            </div>
        </div>

        <?php if ($model['price_new'] > 0) { ?>
            <div class="prod-pricebox">
                <?= Yii::t('app', 'Цена') ?>:
                <span class="for-green">
                    <?= Yii::$app->currency->getValue($model['price_new'], $model['currency']) ?>
                    &nbsp;<span class="currency"><?= Yii::$app->currency->symbol ?></span>
                </span>
            </div>
        <?php } ?>

        <object class="btn-block">
            <a class="more-info">
                <?= Yii::t('app', 'Подробнее') ?>
            </a>
        </object>

    </div>

<?= Html::endTag('a'); ?>