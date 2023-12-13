<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Sale;

/**
 * @var $models Sale
 * @var $model Sale
 */

$detect = new Mobile_Detect();

?>
<style>
    @media screen and (max-width: 768px){
        .home-main .sale-sect .sale-wrap .one-sale {
            width: calc(50% - 20px);
        }
    }

    @media screen and (max-width: 540px){
        .home-main .sale-sect .sale-wrap .one-sale {
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }
    }
</style>


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
            foreach ($models as $key => $model) { ?>
                    <a href="<?= Sale::getUrl($model['alias']) ?>" class="one-sale" data-dominant-color>
                        <div class="img-cont">
                            <span class="background"></span>
                            <?= Html::img('/', [
                                'class' => 'cont lazy her',
                                'alt' => $model['lang']['title'].' '.Yii::t('app', 'фабрика').' '.$model['factory']['title'].' '.Yii::t('app', 'из Италии'),
                                'title' => $model['lang']['title'],
                                'data-src' => Sale::getImageThumb($model['image_link']),
                                'width' => '290px',
                                'height' => '240px'
                            ]) ?>
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
                <?php
                if ($detect->isMobile() && $key == 3) {
                    break;
                }
            } ?>

                <div class="sales-morepanel onlymob">
                    <?= Html::a(
                        Yii::t('app', 'Все акционные товары'),
                        Url::toRoute(['/catalog/sale/list']),
                        ['class' => 'btn-myarredo']
                    ); ?>
                </div>
        </div>
    </div>

</div>
