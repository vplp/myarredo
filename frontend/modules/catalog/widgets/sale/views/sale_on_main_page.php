<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Sale;

/**
 * @var $model \frontend\modules\catalog\models\Category
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
                    <a href="<?= $model->getUrl() ?>" class="one-sale" data-dominant-color itemscope
                       itemtype="http://schema.org/ImageObject">
                        <div class="img-cont">
                            <span class="background"></span>
                            <?= Html::img(
                                Sale::getImageThumb($model['image_link']),
                                [
                                    'class' => 'cont',
                                    'alt' => $model->getTitle(),
                                    'itemprop' => 'contentUrl'
                                ]
                            ) ?>
                        </div>
                        <div class="prod-title" itemprop="name">
                            <?= $model->getTitle() ?>
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