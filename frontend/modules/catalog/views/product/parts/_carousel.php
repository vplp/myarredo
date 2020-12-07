<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/** @var $model Product */

$images = $model->getGalleryImageThumb();

?>

<div id="prod-slider" class="slide carousel-fade">

    <!-- Carousel items -->
    <div class="carousel-inner">

        <?php
        foreach ($images as $key => $src) {
            if ($key == 0) {
                echo Html::beginTag('div', [
                        'class' => 'item active',
                        'data-dominant-color' => '',
                        'itemscope' => '',
                        'itemtype' => 'http://schema.org/ImageObject'
                    ]) .
                    Html::tag('meta', '', ['itemprop' => 'name', 'content' => $model->getTitle()]) .
                    Html::tag('meta', '', ['itemprop' => 'caption', 'content' => Product::getStaticTitleForList($model)]) .
                    Html::tag('link', '', ['itemprop' => 'contentUrl', 'href' => $src['img']]) .
                    Html::tag('meta', '', ['itemprop' => 'description', 'content' => strip_tags($model['lang']['description'])]) .
                    Html::a(
                        Html::img($src['thumb'], ['alt' => $model->getImageAlt()]),
                        $src['img'],
                        [
                            'class' => 'img-cont fancyimage',
                            'data-fancybox-group' => 'group',
                            'data-dominant-color' => '',
                            'data-alt' => $model->getImageAlt()
                        ]
                    ) .
                    Html::tag('span', '', ['class' => 'background']) .
                    Html::endTag('div');

                // echo Html::tag('meta', '', ['itemprop' => 'image', 'content' => $src['img']]);
            } else {
                echo Html::beginTag('div', [
                        'class' => 'item',
                        'data-dominant-color' => '',
                    ]) .
                    Html::a(
                        Html::img($src['thumb']),
                        $src['img'],
                        [
                            'class' => 'img-cont fancyimage',
                            'data-fancybox-group' => 'group',
                            'data-dominant-color' => '',
                            'data-alt' => $model->getImageAlt()
                        ]
                    ) .
                    Html::tag('span', '', ['class' => 'background']) .
                    Html::endTag('div');
            }
        } ?>

    </div>

    <?= Html::a(
        Yii::t('app', 'Увеличить'),
        'javascript:void(0);',
        ['class' => 'img-zoom']
    ) ?>

    <?php if (count($images) > 1) { ?>
        <!-- Carousel nav -->
        <div class="nav-cont">
            <div class="carousel-indicators">

                <?php foreach ($images as $key => $src) { ?>
                    <div class="thumb-item" data-dominant-color>
                        <span class="background"></span>
                        <?= Html::img($src['thumb'], ['alt' => $model->getTitle()]) ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>

</div>
