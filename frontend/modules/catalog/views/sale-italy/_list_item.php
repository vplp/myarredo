<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\ItalianProduct;

/** @var $model ItalianProduct */

?>

<?= Html::beginTag('a', [
    'href' => ItalianProduct::getUrl($model[Yii::$app->languages->getDomainAlias()]),
    'class' => 'one-prod-tile',
]) ?>

<div class="one-prod-tile-in">

    <?php if ($model['bestseller']) { ?>
        <div class="prod-bestseller"><?= Yii::t('app', 'Bestseller') ?></div>
    <?php } ?>

    <?php if (ItalianProduct::getSavingPrice($model)) { ?>
        <div class="prod-saving-percentage"><?= ItalianProduct::getSavingPercentage($model) ?></div>
    <?php } ?>

    <div class="img-cont" data-dominant-color>
        <span class="background"></span>
        <?= Html::img('/', [
            'alt' => $model['lang']['title'].' '.Yii::t('app', 'фабрика').' '.$model['factory']['title'].' '.Yii::t('app', 'из Италии'),
            'title' => $model['lang']['title'],
            'class' => 'lazy',
            'width' => '317',
            'height' => '188',
            'data-src' => ItalianProduct::getImageThumb($model['image_link'])
        ]) ?>
    </div>

    <div class="item-infoblock">
        <div class="tile-brand">
            <?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name'] ?>
        </div>
        <div class="tile-prod-name">
            <?= $model->getTitleForList() ?>
        </div>
    </div>

    <?php if ($model['is_sold']) { ?>
        <div class="prod-is-sold"><?= Yii::t('app', 'Item sold') ?></div>
    <?php } ?>

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
