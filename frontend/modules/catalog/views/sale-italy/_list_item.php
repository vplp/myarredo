<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\ItalianProduct;

/** @var $model ItalianProduct */

?>

<?= Html::beginTag('a', [
    'href' => ItalianProduct::getUrl($model['alias']),
    'class' => 'one-prod-tile'
]) ?>

    <div class="one-prod-tile-in" itemscope itemtype="http://schema.org/ImageObject">

        <div class="img-cont" data-dominant-color>
            <span class="background"></span>
            <?= Html::img(
                ItalianProduct::getImageThumb($model['image_link']),
                [
                    'alt' => $model->getTitle(),
                    'itemprop' => 'contentUrl'
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
                    <?= $model['price_new'] ?>
                    &nbsp;<span class="currency"><?= $model['currency'] ?></span>
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