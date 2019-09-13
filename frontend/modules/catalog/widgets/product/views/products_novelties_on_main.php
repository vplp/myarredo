<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/** @var $models Product[] */
/** @var $model Product */

?>

<div class="novelties">
    <div class="container large-container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="section-header">
                    <h2 class="section-title">
                        <?= Yii::t('app', 'Новинки') ?>
                    </h2>
                    <?= Html::a(
                        Yii::t('app', 'Смотреть все категории'),
                        null,
                        ['class' => 'sticker']
                    ) ?>
                </div>

                <div id="novelties-slider" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">

                        <?php foreach ($models as $k => $level) { ?>
                            <div class="item<?= ($k == 1) ? ' active' : '' ?>">

                                <div class="item-in">
                                    <?php /*
                                    <div class="left">

                                        <?php foreach ($level as $key => $model) {
                                            if ($key == 0) {
                                                echo Html::a(
                                                    Html::img(
                                                        Product::getImageThumb($model['image_link']),
                                                        ['alt' => Product::getStaticTitle($model)]
                                                    ),
                                                    Product::getUrl($model['alias']),
                                                    ['class' => 'large']
                                                );
                                            }
                                        } ?>

                                    </div>
                                    */ ?>

                                    <div class="right">
                                        <?php foreach ($level as $key => $model) {
                                            if ($key < 4) {
                                                echo Html::a(
                                                    Html::img(
                                                        '',
                                                        ['alt' => Product::getStaticTitle($model), 'class' => 'lazy', 'data-src' => Product::getImageThumb($model['image_link'])]
                                                    ),
                                                    Product::getUrl($model['alias']),
                                                    ['class' => 'smaller']
                                                );
                                            }
                                        } ?>
                                    </div>
                                    <div class="right">
                                        <?php foreach ($level as $key => $model) {
                                            if ($key >= 4) {
                                                echo Html::a(
                                                    Html::img(
                                                        '',
                                                        ['alt' => Product::getStaticTitle($model), 'class' => 'lazy', 'data-src' => Product::getImageThumb($model['image_link'])]
                                                    ),
                                                    Product::getUrl($model['alias']),
                                                    ['class' => 'smaller']
                                                );
                                            }
                                        } ?>
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