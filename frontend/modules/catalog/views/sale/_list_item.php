<?php

use yii\helpers\Html;
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

<div class="one-prod-tile-in">

    <?php if (Sale::getSavingPrice($model)) { ?>
        <div class="prod-saving-percentage"><?= Sale::getSavingPercentage($model) ?></div>
    <?php } ?>

    <div class="img-cont" data-dominant-color>
        <span class="background"></span>
        <?= Html::img('/', [
            'alt' => $model->getTitle(),
            'class' => 'lazy',
            'data-src' => Sale::getImageThumb($model['image_link'])
        ]); ?>
    </div>

    <?php if ($model['is_sold']) { ?>
        <div class="prod-is-sold"><?= Yii::t('app', 'Item sold') ?></div>
    <?php } ?>

    <div class="item-infoblock">
        <div class="tile-brand">
            <?= ($model['factory']) ? $model['factory']['title'] : $model['factory_name'] ?>
        </div>
        <div class="tile-prod-name">
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
