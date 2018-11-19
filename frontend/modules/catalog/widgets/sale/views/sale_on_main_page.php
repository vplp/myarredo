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
            <h3 class="section-title">
                <?= Yii::t('app', 'Sale') ?>
            </h3>
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
                                <?= $model['price'] ?> <?= $model['currency'] ?></span> | <span class="new-price">
                                <?= $model['price_new'] ?></span> <?= $model['currency'] ?>
                        </div>
                    </a>
                <?php }
            } ?>
        </div>
    </div>

</div>