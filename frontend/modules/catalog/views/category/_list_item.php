<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Product, Factory
};

/** @var $model Product */
/** @var $bestsellers */

$bestsellers = $bestsellers ?? [];

?>

<?= Html::beginTag('a', [
    'href' => Product::getUrl($model[Yii::$app->languages->getDomainAlias()]),
    'class' => 'one-prod-tile',
]) ?>
<div class="one-prod-tile-in">

    <?php if ($model['bestseller'] || in_array($model['id'], $bestsellers)) { ?>
        <div class="prod-bestseller"><?= Yii::t('app', 'Bestseller') ?></div>
    <?php } ?>

    <?php if ($model['novelty']) { ?>
        <div class="prod-novelty"><?= Yii::t('app', 'Novelty') ?></div>
    <?php } ?>

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
        <?= Html::img('/', [
            'alt' => Product::getStaticTitleForList($model),
            'class' => 'lazy',
            'width' => '317',
            'height' => '188',
            'data-src' => Product::getImageThumb($model['image_link'])
        ]) ?>
    </div>

    <div class="prod-infoblock">
        <div class="tile-brand">
            <?= $model['factory']['title'] ?>
        </div>
        <div class="tile-prod-name">
            <?= Product::getStaticTitleForList($model); ?>
        </div>
    </div>

    <?php if (!Yii::$app->getUser()->isGuest && in_array(Yii::$app->user->identity->group->role, ['admin', 'partner']) && Yii::$app->city->isShowPrice() && !$model['removed'] && $model['price_from'] > 0) { ?>
        <div class="prod-pricebox">
            <?= Yii::t('app', 'Цена от') ?><span>&#126;</span>
            <span class="for-green">
                    <?= Yii::$app->currency->getValue($model['price_from'], $model['currency']) ?>
                    &nbsp;<span class="currency"><?= Yii::$app->currency->symbol ?></span>
                </span>
        </div>
    <?php } elseif (Yii::$app->request->get('page') == false && Yii::$app->city->isShowPrice() && !$model['removed'] && $model['price_from'] > 0) { ?>
        <div class="prod-pricebox">
            <?= Yii::t('app', 'Цена от') ?><span>&#126;</span>
            <span class="for-green">
                    <?= Yii::$app->currency->getValue($model['price_from'], $model['currency']) ?>
                    &nbsp;<span class="currency"><?= Yii::$app->currency->symbol ?></span>
                </span>
        </div>
    <?php } ?>

    <object class="btn-block">
        <button class="ajax-request-price more-info" data-id=<?= $model['id'] ?>>
            <?= Yii::t('app', 'Уточнить цену') ?>
        </button>
    </object>
</div>

<?= Html::endTag('a') ?>
