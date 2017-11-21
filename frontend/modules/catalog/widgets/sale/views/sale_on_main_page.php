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

<div class="sale">
    <div class="container large-container">
        <div class="row">
            <div class="col-ms-12">
                <div class="header">
                    <h2>Распродажа</h2>

                    <?= Html::a(
                        'Все акционные товары',
                        Url::toRoute(['/catalog/sale/list']),
                        ['class' => 'more']
                    ); ?>

                    <div id="sale-slider" class="carousel slide" data-ride="carousel" data-interval="10000">

                        <div class="carousel-inner">

                            <?php foreach ($models as $k => $level) { ?>

                                <div class="item<?= ($k == 1) ? ' active' : '' ?>">
                                    <div class="item-in">
                                        <div class="left-side">

                                            <?php foreach ($level as $key => $model) { ?>

                                                <?php if ($key + 1 !== count($level)) { ?>

                                                    <?= Html::beginTag('a', ['href' => $model->getUrl(), 'class' => 'one-tile']); ?>
                                                        <div class="img-cont">
                                                            <?= Html::img(Sale::getImage($model['image_link']), ['class' => 'cont']); ?>
                                                        </div>
                                                        <div class="name">
                                                            <?= $model->getTitle(); ?>
                                                        </div>

                                                        <?php if ($model['price'] > 0): ?>
                                                            <div class="old-price"><?= $model['price']; ?> <?= $model['currency']; ?></div>
                                                        <?php endif; ?>
                                                        <div class="new-price">
                                                            <?= $model['price_new']; ?> <?= $model['currency']; ?>
                                                        </div>
                                                    <?= Html::endTag('a'); ?>

                                                <?php } else { ?>

                                                    </div>
                                                    <div class="right-side">

                                                        <?= Html::beginTag('a', ['href' => $model->getUrl(), 'class' => 'one-tile']); ?>
                                                            <div class="img-cont">
                                                                <?= Html::img(Sale::getImage($model['image_link']), ['class' => 'cont']); ?>
                                                            </div>
                                                            <div class="name">
                                                                <?= $model->getTitle(); ?>
                                                            </div>
                                                            <?php if ($model['price'] > 0): ?>
                                                                <div class="old-price"><?= $model['price']; ?> <?= $model['currency']; ?></div>
                                                            <?php endif; ?>
                                                            <div class="new-price">
                                                                <?= $model['price_new']; ?> <?= $model['currency']; ?>
                                                            </div>
                                                        <?= Html::endTag('a'); ?>

                                                <?php } ?>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                        <div class="arr-cont">
                            <a class="left left-arr" href="#sale-slider" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <div class="indent"></div>
                            <a class="right right-arr" href="#sale-slider" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>