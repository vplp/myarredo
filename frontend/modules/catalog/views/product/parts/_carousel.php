<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/** @var $model Product */

$images = Product::getGalleryImageThumb($model->gallery_image);

?>

<?php foreach ($images as $key => $src) {
    echo Html::tag('link', '', ['itemprop' => 'image', 'href' => $src['img']]);
} ?>

<div id="prod-slider" class="slide carousel-fade">

    <!-- Carousel items -->
    <div class="carousel-inner">

        <?php
        foreach ($images as $key => $src) {
            if ($key == 0) {
                echo Html::beginTag('div', [
                        'class' => 'item active',
                        'data-dominant-color' => '',
                        'itemscope' => true,
                        'itemtype' => 'http://schema.org/ImageObject'
                    ]) .
                    Html::tag('meta', '', ['itemprop' => 'name', 'content' => Product::getStaticTitle($model)]) .
                    Html::tag('meta', '', ['itemprop' => 'caption', 'content' => Product::getStaticTitleForList($model)]) .
                    Html::tag('link', '', ['itemprop' => 'contentUrl', 'href' => $src['img']]) .
                    Html::tag('meta', '', ['itemprop' => 'description', 'content' => strip_tags($model->lang->description)]) .
                    Html::a(
                        Html::img(
                            $src['thumb'],
                            [
                                'alt' => $model->lang->title.' '.Yii::t('app', 'фабрика').' '.$model->factory->title.' '.Yii::t('app', 'из Италии').'. '.Yii::t('app', 'Фото №').($key+1),
                                'title' => Product::getStaticTitle($model),
                                'width' => '555',
                                'height' => '382',
                                'class' => '111',
                                'itemprop' => 'image'
                            ]
                        ),
                        $src['img'],
                        [
                            'class' => 'img-cont fancyimage',
                            'data-fancybox-group' => 'group',
                            'data-dominant-color' => '',
                            'data-title' => Product::getStaticTitle($model),
                            'data-alt' => $model->lang->title.' '.Yii::t('app', 'фабрика').' '.$model->factory->title.' '.Yii::t('app', 'из Италии').'. '.Yii::t('app', 'Фото №').($key+1)
                        ]
                    ) .
                    Html::tag('span', '', ['class' => 'background']) .
                    Html::endTag('div');
            } else {
                echo Html::beginTag('div', [
                        'class' => 'item',
                        'data-dominant-color' => '',
                        'itemscope' => true,
                        'itemtype' => 'http://schema.org/ImageObject'
                    ]) .
                    Html::tag('meta', '', ['itemprop' => 'name', 'content' => Product::getStaticTitle($model)]) .
                    Html::tag('meta', '', ['itemprop' => 'caption', 'content' => Product::getStaticTitleForList($model)]) .
                    Html::tag('link', '', ['itemprop' => 'contentUrl', 'href' => $src['img']]) .
                    Html::tag('meta', '', ['itemprop' => 'description', 'content' => strip_tags($model->lang->description)]) .
                    Html::a(
                        Html::img(
                            $src['thumb'],
                            [
                                'alt' => $model->lang->title.' '.Yii::t('app', 'фабрика').' '.$model->factory->title.' '.Yii::t('app', 'из Италии').'. '.Yii::t('app', 'Фото №').($key+1),
                                'title' => Product::getStaticTitle($model),
                                'width' => '555',
                                'height' => '382',
                                'class' => '111',
                                'itemprop' => 'image'
                            ]
                        ),
                        $src['img'],
                        [
                            'class' => 'img-cont fancyimage',
                            'data-fancybox-group' => 'group',
                            'data-dominant-color' => '',
                            'data-title' => Product::getStaticTitle($model),
                            'data-alt' => $model->lang->title.' '.Yii::t('app', 'фабрика').' '.$model->factory->title.' '.Yii::t('app', 'из Италии').'. '.Yii::t('app', 'Фото №').($key+1)
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
                        <?= Html::img($src['thumb'], ['alt' => $model->lang->title.' '.Yii::t('app', 'фабрика').' '.$model->factory->title.' '.Yii::t('app', 'из Италии').'. '.Yii::t('app', 'Фото №').($key+1), 'title' => Product::getStaticTitle($model), 'width' => '138', 'height' => '95', 'class' => '22']) ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>

</div>
