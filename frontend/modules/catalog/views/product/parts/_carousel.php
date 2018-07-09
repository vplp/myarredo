<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<div id="prod-slider" class="slide carousel-fade">

    <!-- Carousel items -->
    <div class="carousel-inner">

        <?php foreach ($model->getGalleryImageThumb() as $key => $src) {

            $class = 'item' . (($key == 0) ? ' active' : '');

            $options = ($key == 0) ? ['itemprop' => 'image', 'alt' => $model->getTitle()] : ['itemprop' => 'image'];

            echo Html::beginTag('div', ['class' => $class, 'data-dominant-color' => '']) .
                Html::a(
                    Html::img($src['thumb'], $options),
                    $src['img'],
                    [
                        'class' => 'img-cont fancyimage',
                        'data-fancybox-group' => 'group',
                        'data-dominant-color' => ''
                    ]
                ) .
                Html::tag('span', '', ['class' => 'background']) .
                Html::endTag('div');
        } ?>

    </div>

    <a href="javascript:void(0);" class="img-zoom">
        <?= Yii::t('app','Увеличить') ?>
    </a>

    <!-- Carousel nav -->

    <div class="nav-cont">
        <div class="carousel-indicators">

            <?php foreach ($model->getGalleryImageThumb() as $key => $src): ?>

                <div class="thumb-item" data-dominant-color>
                    <span class="background"></span>
                    <?= Html::img($src['thumb']); ?>
                </div>

            <?php endforeach; ?>

        </div>
    </div>

</div>