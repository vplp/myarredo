<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\forms\widgets\FormFeedback;
use frontend\modules\user\widgets\partner\MainPartnerMap;

/** @var $partners array */

$mainPartner = array_shift($partners);
?>

<!-- main partner -->
<div class="one-cont double-cont">
    <div class="top-mainpart">
        <div class="main-sticker">
            <?= Yii::t('app', 'Главный партнер') ?>
        </div>
        <?= Html::tag('h2', $mainPartner->profile->getNameCompany()); ?>
    </div>

    <div class="adress-mainpart">
        <div class="partner-adressbox">
            <div class="adres">
                <span class="for-adress"><?= Yii::t('app', 'Address') ?>:</span>
                <?= isset($mainPartner->profile->city)
                    ? $mainPartner->profile->city->lang->title . '<br>'
                    : '' ?>
                <?= $mainPartner->profile->lang->address ?>
            </div>
            <div class="adres">
                <?= ($mainPartner->profile->working_hours_start && $mainPartner->profile->working_hours_end)
                    ? '<span class="for-mode">' . Yii::t('app', 'Режим работы салона') . ':</span>' . $mainPartner->profile->working_hours_start . ' - ' . $mainPartner->profile->working_hours_end
                    : '' ?>
            </div>
        </div>
        <div class="partner-phonebox">
            <span class="for-phone"><?= Yii::t('app', 'Phone') ?>:</span>
            <?= Html::a(
                $mainPartner->profile->phone,
                'tel:' . $mainPartner->profile->phone,
                []
            ) ?>
        </div>
    </div>

    <?php if ($mainPartner->profile->lang->address2) { ?>
        <div class="adress-mainpart">
            <div class="partner-adressbox">

                <div class="adres">
                    <span class="for-adress"><?= Yii::t('app', 'Address') ?>:</span>
                    <?= isset($mainPartner->profile->city)
                        ? $mainPartner->profile->city->lang->title . '<br>'
                        : '' ?>
                    <?= $mainPartner->profile->lang->address2 ?>

                </div>

                <div class="adres">
                    <?= ($mainPartner->profile->working_hours_start2 && $mainPartner->profile->working_hours_end2)
                        ? '<span class="for-mode">' . Yii::t('app', 'Режим работы салона') . ':</span>' . $mainPartner->profile->working_hours_start2 . ' - ' . $mainPartner->profile->working_hours_end2
                        : '' ?>
                </div>

                <?php if ($mainPartner->profile->phone2) { ?>
                <div class="partner-phonebox">
                    <span class="for-phone"><?= Yii::t('app', 'Phone') ?>:</span>
                    <?= Html::a(
                        $mainPartner->profile->phone2,
                        'tel:' . $mainPartner->profile->phone2,
                        []
                    ); ?>
                </div>

            <?php } ?>

            </div>
        </div>
    <?php } ?>

    <div class="bottom-mainpart">
        <div class="partner-sitebox">
            <span class="for-site"><?= Yii::t('app', 'Адресс сайта') ?>:</span>
            <?= Html::a(
                $mainPartner->profile->website,
                $mainPartner->profile->website,
                ['target' => '_blank', 'rel' => 'nofollow']
            ) ?>
        </div>
    </div>

    <?php if ($mainPartner->profile->getImageLink('image_salon') || $mainPartner->profile->getImageLink('image_salon2')) { ?>
        <div class="partner-imagepart">
            <!-- slider container -->
            <div class="contact-partner-slider">

                <?php if ($mainPartner->profile->getImageLink('image_salon')) { ?>
                    <div class="img-cont">
                        <?= Html::img($mainPartner->profile->getImageLink('image_salon')) ?>
                    </div>
                <?php } ?>

                <?php if ($mainPartner->profile->getImageLink('image_salon2')) { ?>
                    <div class="img-cont">
                        <?= Html::img($mainPartner->profile->getImageLink('image_salon2')) ?>
                    </div>
                <?php } ?>

            </div>
            <!-- end slider container -->
        </div>
    <?php } ?>

    <div class="partner-formbox hidden">
        <?= FormFeedback::widget([
            'partner_id' => $mainPartner->id,
            'view' => 'form_feedback_partner'
        ]) ?>
    </div>
</div>
<div class="one-cont double-cont map-cont contact-mapbox">
    <?= MainPartnerMap::widget(['id' => $mainPartner->id]) ?>
</div>
<!-- end main partner -->