<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\ItalianProduct;

/**
 * @var $models ItalianProduct
 * @var $model ItalianProduct
 */

?>

<div class="sale-sect">
    <div class="container large-container">
        <div class="section-header">
            <h2 class="section-title">
                <?= Yii::t('app', 'Sale in Italy') ?>
            </h2>
            <?= Html::a(
                Yii::t('app', 'Все акционные товары'),
                Url::toRoute(['/catalog/sale-italy/list']),
                ['class' => 'sticker']
            ); ?>
        </div>
        <div class="sale-wrap">
            <?php
            foreach ($models as $k => $level) {
                foreach ($level as $key => $model) { ?>
                    <a href="<?= ItalianProduct::getUrl($model['alias']) ?>" class="one-sale" data-dominant-color>
                        <div class="img-cont">
                            <span class="background"></span>
                            <?= Html::img(
                                '',
                                [
                                    'class' => 'cont lazy',
                                    'alt' => $model['lang']['title'],
                                    'data-src' => ItalianProduct::getImageThumb($model['image_link'])
                                ]
                            ) ?>
                        </div>
                        <div class="prod-title">
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
