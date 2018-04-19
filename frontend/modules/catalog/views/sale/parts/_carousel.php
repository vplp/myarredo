<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Sale $model
 */

?>

<div id="prod-slider" class=" carousel-fade" >

    <!-- Carousel items -->
    <div class="carousel-inner">

        <?php foreach ($model->getFrontGalleryImage() as $key => $src) {

            echo Html::beginTag('div', ['class' => $class, 'data-dominant-color' => '']) .
                Html::a(
                    Html::img($src['img'], ['itemprop' => 'image']),
                    $src['img'],
                    [
                        'class' => 'img-cont fancyimage',
                        'data-fancybox-group' => 'group'
                    ]
                ) .
                Html::tag('span', '', ['class' => 'background']) .
                Html::endTag('div');
        } ?>

    </div>

    <a href="javascript:void(0);" class="img-zoom">
        <?= Yii::t('app', 'Увеличить') ?>
    </a>

    <!-- Carousel nav -->

    <div class="nav-cont">
        <ol class="carousel-indicators">

            <?php foreach ($model->getFrontGalleryImage() as $key => $src): ?>

                <div class="thumb-item" data-dominant-color>
                    <span class="background"></span>
                    <?= Html::img($src['thumb']); ?>
                </div>

            <?php endforeach; ?>

        </ol>
    </div>

</div>