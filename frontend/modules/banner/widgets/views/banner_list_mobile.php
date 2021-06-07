<?php

use frontend\modules\banner\models\BannerItem;

/**
 * @var $model BannerItem
 */

if (!empty($items)) {
    $model = $items[0];

    Yii::$app->view->registerLinkTag([
        'rel' => 'preload',
        'href' => $model->getImageThumb(),
        'as' => 'image'
    ]);
    ?>

    <div class="home-top-slider">
        <div class="img-cont">
            <?php if (isset($model['lang']['link'])) { ?>
                <a href="<?= $model['lang']['link']?>">
                    <img width="375" height="162" src="<?= $model->getImageThumb(); ?>" alt="">
                </a>
            <?php } else { ?>
                <img width="375" height="162" src="<?= $model->getImageThumb(); ?>" alt="">
            <?php } ?>

            <span><?= $model['lang']['description'] ?? ''; ?></span>
        </div>
    </div>
<?php } ?>
