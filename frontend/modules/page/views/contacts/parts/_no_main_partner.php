<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\widgets\partner\PartnerMap;

/** @var $partners array */

?>

<!-- main partner -->
<div class="one-cont double-cont">
    <div class="top-mainpart">
        <div class="main-sticker">
            <?= Yii::t('app', 'Главный партнер') ?>
        </div>
    </div>

    <div class="partner-phonebox">
        <span class="for-phone">Телефон:</span>
        <?= Html::a(
            Yii::$app->partner->getPartnerPhone(),
            'tel:' . Yii::$app->partner->getPartnerPhone(),
            []
        ); ?>
    </div>
</div>
<div class="one-cont double-cont map-cont contact-mapbox">
    <?= PartnerMap::widget(['city' => Yii::$app->city->getCity(), 'defaultMarker' => '/img/marker-main.png']) ?>
</div>
<!-- end main partner -->