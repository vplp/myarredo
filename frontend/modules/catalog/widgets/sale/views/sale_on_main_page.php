<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Sale;

/**
 * @var $models Sale
 * @var $model Sale
 */

?>

<div class="sale-sect">
    <div class="container large-container">
        <div class="section-header">
            <h2 class="section-title">
                <?= Yii::t('app', 'Sale') ?>
            </h2>
            <?= Html::a(
                Yii::t('app', 'Все акционные товары'),
                Url::toRoute(['/catalog/sale/list']),
                ['class' => 'sticker']
            ); ?>
        </div>
        <div class="sale-wrap">
            <?php
            foreach ($models as $k => $level) {
                foreach ($level as $key => $model) { ?>
                    <a href="<?= Sale::getUrl($model['alias']) ?>" class="one-sale" data-dominant-color itemscope
                       itemtype="http://schema.org/ImageObject">
                        <div class="img-cont">
                            <span class="background"></span>
                            <?= Html::img(
                                Sale::getImageThumb($model['image_link']),
                                [
                                    'class' => 'cont',
                                    'alt' => $model['lang']['title'],
                                    'itemprop' => 'contentUrl'
                                ]
                            ) ?>
                        </div>
                        <div class="prod-title" itemprop="name">
                            <?= $model['lang']['title'] ?>
                        </div>
                        <div class="price">
                            <span class="old-price">
                                <?= Yii::$app->currency->getValue($model['price'], $model['currency']) . ' ' .
                                Yii::$app->currency->symbol; ?>
                            </span> |
                            <span class="new-price">
                                <?= Yii::$app->currency->getValue($model['price_new'], $model['currency']) ?>
                            </span> <?= Yii::$app->currency->symbol ?>
                        </div>
                    </a>
                <?php }
            } ?>
        </div>
    </div>

</div>