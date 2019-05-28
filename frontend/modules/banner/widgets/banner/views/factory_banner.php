<?php

use yii\helpers\Html;
//
use frontend\modules\banner\models\BannerItem;

/**
 * @var $model BannerItem
 */


if (!empty($items)) { ?>
    <div class="fact-slider">

        <?php foreach ($items as $model) { ?>
            <div class="img-cont">
                <?php if ($model['lang']['link'] != '') {
                    echo Html::a(Html::img($model->getImageLink()), $model['lang']['link'], []);
                } else {
                    echo Html::img($model->getImageLink());
                } ?>
                <span><?= $model['lang']['title']; ?></span>
            </div>
        <?php } ?>

    </div>

    <?php
}

$script = <<<JS
$(document).ready(function() {
    $('.fact-slider').slick({
        autoplay: true,
        dots: true,
        arrows: false,
        fade: true,
        cssEase: 'linear',
        autoplaySpeed: 3000
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);

