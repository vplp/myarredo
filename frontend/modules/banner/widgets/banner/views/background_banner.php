<?php

use yii\helpers\Html;
//
use frontend\modules\banner\models\BannerItem;

/**
 * @var $background string
 * @var $bannerLeft BannerItem
 * @var $bannerRight BannerItem
 */
?>

<?php if (!empty($bannerLeft) && !empty($bannerRight)) { ?>
    <div class="fone-poster-box" style="background-color:<?= $background ?>;">

        <div class="fone-poster-left">
            <?php if ($bannerLeft['lang']['link'] != '') {
                echo Html::a(
                    Html::img($bannerLeft->getImageLink()),
                    $bannerLeft['lang']['link'],
                    ['class' => 'fone-poster-link']
                );
            } else {
                echo Html::img($bannerLeft->getImageLink());
            } ?>
        </div>

        <div class="fone-poster-right">
            <?php if ($bannerRight['lang']['link'] != '') {
                echo Html::a(
                    Html::img($bannerRight->getImageLink()),
                    $bannerRight['lang']['link'],
                    ['class' => 'fone-poster-link']
                );
            } else {
                echo Html::img($bannerRight->getImageLink());
            } ?>
        </div>

    </div>
<?php } ?>
