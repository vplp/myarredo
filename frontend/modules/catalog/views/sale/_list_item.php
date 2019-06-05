<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Sale;

/**
 * @var $model Sale
 */

?>

<?= Html::beginTag('a', [
    'href' => Sale::getUrl($model['alias']),
    'class' => 'one-prod-tile'
]); ?>

    <div class="one-prod-tile-in" itemscope itemtype="http://schema.org/ImageObject">

        <div class="img-cont" data-dominant-color>
            <span class="background"></span>
            <?= Html::img(
                Sale::getImageThumb($model['image_link']),
                [
                    'alt' => $model->getTitle(),
                    'itemprop' => 'contentUrl'
                ]
            ); ?>
        </div>

        <div class="item-infoblock">
            <div class="tile-brand">
                <?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name'] ?>
            </div>
            <div class="tile-prod-name" itemprop="name">
                <?= $model['lang']['title'] ?>
            </div>
        </div>

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