<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

?>

<div class="novelties">
    <div class="container large-container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="section-header">
                    <h3 class="section-title">
                        <?= Yii::t('app', 'Новинки') ?>
                    </h3>
                    <a href="#" class="sticker">
                        <?= Yii::t('app', 'Смотреть все категории') ?>
                    </a>
                </div>

                <div id="novelties-slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

                        <?php foreach ($models as $k => $level) { ?>
                            <div class="item<?= ($k == 1) ? ' active' : '' ?>">

                                <div class="item-in">
                                    <div class="left">

                                        <?php foreach ($level as $key => $model) { ?>
                                            <?php if ($key == 0) { ?>
                                                <a href="<?= Product::getUrl($model['alias']) ?>" class="large">
                                                    <?= Html::img(
                                                        Product::getImageThumb($model['image_link']),
                                                        ['alt' => Product::getStaticTitle($model)]
                                                    ); ?>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>

                                    </div>
                                    <div class="right">

                                        <?php foreach ($level as $key => $model) { ?>
                                            <?php if ($key > 0) { ?>
                                                <a href="<?= Product::getUrl($model['alias']) ?>" class="smaller">
                                                    <?= Html::img(
                                                        Product::getImageThumb($model['image_link']),
                                                        ['alt' => Product::getStaticTitle($model)]
                                                    ); ?>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>

                    <div class="arr-cont">
                        <a class="left left-arr" href="#novelties-slider" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right right-arr" href="#novelties-slider" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>