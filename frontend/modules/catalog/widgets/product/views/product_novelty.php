<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

?>

<!-- Новинки -->

<div class="novelties">
    <div class="container large-container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="header">
                    <h2>Новинки</h2>
                    <a href="#" class="more">Смотреть все категории</a>
                    <div id="novelties-slider" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">

                            <?php foreach ($models as $k => $level) { ?>

                                <div class="item<?= ($k == 1) ? ' active' : '' ?>">

                                    <div class="item-in">

                                        <div class="left">

                                            <?php foreach ($level as $key => $model) { ?>

                                                <?php if ($key == 0) { ?>
                                                    <a href="<?= Product::getUrl($model['alias']) ?>" class="large">
                                                        <?= Html::img(Product::getImage($model['image_link'])); ?>
                                                    </a>
                                                <?php } ?>

                                            <?php } ?>

                                        </div>

                                        <div class="right">

                                        <?php foreach ($level as $key => $model) { ?>

                                            <?php if ($key > 0) { ?>
                                                <a href="<?= Product::getUrl($model['alias']) ?>" class="smaller">
                                                    <?= Html::img(Product::getImage($model['image_link'])); ?>
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
                            <div class="indent"></div>
                            <a class="right right-arr" href="#novelties-slider" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- конец Новинки -->