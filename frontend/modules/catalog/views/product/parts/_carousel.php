<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Product;

/**
 * @var $model Product
 */

?>

<div id="prod-slider" class="slide carousel-fade">

    <!-- Carousel items -->
    <div class="carousel-inner">

        <?php
        foreach ($model->getGalleryImageThumb() as $key => $src) {
            if ($key == 0) {
                echo Html::beginTag('div', [
                        'class' => 'item active',
                        'data-dominant-color' => '',
                        'itemscope' => '',
                        'itemtype' => 'http://schema.org/ImageObject'
                    ]) .
                    Html::tag('meta', '', ['itemprop' => 'name', 'content' => $model->getTitle()]) .
                    Html::tag('meta', '', ['itemprop' => 'caption', 'content' => Product::getStaticTitleForList($model)]) .
                    Html::tag('meta', '', ['itemprop' => 'contentUrl', 'content' => $src['thumb']]) .
                    Html::tag('meta', '', ['itemprop' => 'description', 'content' =>  strip_tags($model['lang']['description'])]) .
                    Html::a(
                        Html::img($src['thumb'], ['itemprop' => 'image', 'alt' => $model->getTitle()]),
                        $src['img'],
                        [
                            'class' => 'img-cont fancyimage',
                            'data-fancybox-group' => 'group',
                            'data-dominant-color' => '',
                            'data-alt' => $model->getTitle()
                        ]
                    ) .
                    Html::tag('span', '', ['class' => 'background']) .
                    Html::endTag('div');
            } else {
                echo Html::beginTag('div', [
                        'class' => 'item',
                        'data-dominant-color' => ''
                    ]) .
                    Html::a(
                        Html::img($src['thumb'], ['itemprop' => 'image']),
                        $src['img'],
                        [
                            'class' => 'img-cont fancyimage',
                            'data-fancybox-group' => 'group',
                            'data-dominant-color' => '',
                            'data-alt' => $model->getTitle()
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

    <!-- Carousel nav -->

    <div class="nav-cont">
        <div class="carousel-indicators">

            <?php foreach ($model->getGalleryImageThumb() as $key => $src) { ?>
                <div class="thumb-item" data-dominant-color>
                    <span class="background"></span>
                    <?= Html::img($src['thumb'], ['alt' => $model->getTitle()]); ?>
                </div>
            <?php } ?>

        </div>
    </div>

</div>
