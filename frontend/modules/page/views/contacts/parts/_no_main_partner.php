<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\user\widgets\partner\PartnerMap;

?>

<!-- main partner -->
<div class="one-cont double-cont no-partner">
    <div class="top-mainpart">
        <div class="main-sticker">
            <?= Yii::t('app', 'Главный партнер') ?>
        </div>
        <div class="partner-phonebox">
            <span class="for-phone"> <?= Yii::t('app', 'Здесь может быть ваша реклама') ?>:</span>
            <?= Html::a(
                Yii::$app->partner->getPartnerPhone(),
                'tel:' . Yii::$app->partner->getPartnerPhone(),
                []
            ); ?>
        </div>

        <div class="partner-maybyphoto">
            <span class="for-mayby">
                <?= Html::a(
                    Yii::t('app', 'Стать главным партнером в городе') . '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                    'https://www.myarredo.ru/uploads/myarredofamily-for-partners.pdf',
                    ['class' => 'btn btn-gopartner  click-on-become-partner', 'target' => '_blank']
                ); ?>
            </span>
        </div>
    </div>
</div>
<div class="one-cont double-cont map-cont contact-mapbox">
    <?= PartnerMap::widget(['city' => Yii::$app->city->getCity(), 'defaultMarker' => '/img/marker.png']) ?>
</div>
<!-- end main partner -->
