<?php

use yii\helpers\Html;
use frontend\modules\banner\models\BannerItem;

/**
 * @var $background string
 * @var $bannerLeft BannerItem
 * @var $bannerRight BannerItem
 */
?>

<?php if (!empty($bannerLeft) && !empty($bannerRight)) { ?>
    <div class="fone-poster-box" style="background-color:<?= $background ? $background : 'transparent' ?>;">

        <div class="fone-poster-left">
            <?php if ($bannerLeft['lang'] && $bannerLeft['lang']['link'] != '') {
                echo Html::a(
                    Html::img('/', ['class' => 'lazy', 'data-src' => $bannerLeft->getImageLink(), 'alt' => $bannerLeft['lang']['link']),
                    $bannerLeft['lang']['link'],
                    ['class' => 'fone-poster-link']]
                );
            } else {
                echo Html::img('/', ['class' => 'lazy', 'data-src' => $bannerLeft->getImageLink()]);
            } ?>
        </div>

        <div class="fone-poster-right">
            <?php if ($bannerLeft['lang'] && $bannerRight['lang']['link'] != '') {
                echo Html::a(
                    Html::img('/', ['class' => 'lazy', 'data-src' => $bannerRight->getImageLink(), 'alt' => $bannerRight['lang']['link']),
                    $bannerRight['lang']['link'],
                    ['class' => 'fone-poster-link']
                );
            } else {
                echo Html::img('/', ['class' => 'lazy', 'data-src' => $bannerRight->getImageLink()]);
            } ?>
        </div>

    </div>
<?php } ?>
