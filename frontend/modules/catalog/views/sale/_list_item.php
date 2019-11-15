<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Sale;

/**
 * @var $model Sale
 */

$hostInfo = $hostInfo ?? Yii::$app->request->hostInfo;
?>

<?= Html::beginTag('a', [
    'href' => $hostInfo . Sale::getUrl($model['alias'], false),
    'class' => 'one-prod-tile',
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
                    'data-src' => Sale::getImageThumb($model['image_link'])
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