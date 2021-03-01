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
                <?php if (isset($model['lang']) && $model['lang']['link'] != '') {
                    echo Html::a(Html::img($model->getImageLink()), $model['lang']['link'], []);
                } else {
                    echo Html::img($model->getImageLink());
                } ?>

                <?php if (isset($model['lang']) && $model['lang']['description'] != '') {
                    echo Html::tag('span', $model['lang']['description']);
                } ?>
            </div>
        <?php } ?>

    </div>

    <?php
}

