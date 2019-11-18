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

