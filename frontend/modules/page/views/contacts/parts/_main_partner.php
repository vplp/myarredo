<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\forms\widgets\FormFeedback;
use frontend\modules\user\widgets\partner\MainPartnerMap;

/** @var $partners array */

$mainPartner = array_shift($partners);
?>

<!-- main partner -->
<div class="one-cont double-cont" itemscope itemtype="http://schema.org/Organization">
    <div class="top-mainpart">
        <div class="main-sticker">
            <?= Yii::t('app', 'Главный партнер') ?>
        </div>
        <?= Html::tag('h2', $mainPartner->profile->getNameCompany(), ['itemprop' => 'name']); ?>
    </div>

    <div class="adress-mainpart">
        <div class="partner-adressbox">
            <?php if (isset($mainPartner->profile->lang->address) && $mainPartner->profile->lang->address != '') { ?>
                <div class="adres" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <span class="for-adress"><?= Yii::t('app', 'Address') ?>:</span>
                    <?php if ($mainPartner->profile->latitude && $mainPartner->profile->longitude) {
                        echo Html::a(
                            Html::tag(
                                'span',
                                $mainPartner->profile->lang->address ?? '',
                                ['class' => 'streetAddress']
                            ),
                            'http://www.google.com/maps/place/' . $mainPartner->profile->latitude . ',' . $mainPartner->profile->longitude,
                            ['target' => '_blank']
                        );
                    } else {
                        echo Html::tag(
                            'span',
                            $mainPartner->profile->lang->address ?? '',
                            ['class' => 'streetAddress']
                        );
                    } ?>
                    <br>
                    <span itemprop="addressLocality">
                        <?= isset($mainPartner->profile->city)
                            ? $mainPartner->profile->city->getTitle() . ', ' . $mainPartner->profile->country->getTitle()
                            : '' ?>
                    </span>
                </div>
            <?php } ?>

            <div class="adres">
                <?= ($mainPartner->profile->working_hours_start && $mainPartner->profile->working_hours_end)
                    ? '<span class="for-mode">' .
                    Yii::t('app', 'Режим работы салона') .
                    ':</span>' .
                    $mainPartner->profile->working_hours_start . ' - ' .
                    $mainPartner->profile->working_hours_end
                    : '' ?>
            </div>
        </div>
        <div class="partner-phonebox">
            <span class="for-phone"><?= Yii::t('app', 'Phone') ?>:</span>
            <?= Html::a(
                $mainPartner->profile->phone,
                'tel:' . $mainPartner->profile->phone,
                ['itemprop' => 'telephone']
            ) ?>
        </div>
    </div>

    <?php if (isset($mainPartner->profile->lang->address2) && $mainPartner->profile->lang->address2 != '') { ?>
        <div class="adress-mainpart">
            <div class="partner-adressbox">

                <div class="adres" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <span class="for-adress"><?= Yii::t('app', 'Address') ?>:</span>
                    <?php if ($mainPartner->profile->latitude2 && $mainPartner->profile->longitude2) {
                        echo Html::a(
                            Html::tag(
                                'span',
                                $mainPartner->profile->lang->address2 ?? '',
                                ['class' => 'streetAddress']
                            ),
                            'http://www.google.com/maps/place/' . $mainPartner->profile->latitude2 . ',' . $mainPartner->profile->longitude2,
                            ['target' => '_blank']
                        );
                    } else {
                        echo Html::tag(
                            'span',
                            $mainPartner->profile->lang->address2 ?? '',
                            ['class' => 'streetAddress']
                        );
                    } ?>
                    <br>
                    <span itemprop="addressLocality">
                        <?= isset($mainPartner->profile->city)
                            ? $mainPartner->profile->city->getTitle() . ', ' . $mainPartner->profile->country->getTitle()
                            : '' ?>
                    </span>
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
                            ['itemprop' => 'telephone']
                        ); ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    <?php } ?>

    <?php if (isset($mainPartner->profile->website) && $mainPartner->profile->website != '') { ?>
        <div class="bottom-mainpart">
            <div class="partner-sitebox">
                <span class="for-site"><?= Yii::t('app', 'Адресс сайта') ?>:</span>
                <?= Html::a(
                    $mainPartner->profile->website,
                    $mainPartner->profile->website,
                    ['target' => '_blank', 'rel' => 'nofollow', 'itemprop' => 'url']
                ) ?>
            </div>
        </div>
    <?php } ?>

    <?php /*
    <div class="send-salon-panel">
        <?= Html::a(Yii::t('app', 'Написать салону'), 'javascript:void(0);', [
            'class' => 'btn btn-myarredo',
            'data-toggle' => 'modal',
            'data-target' => '#modalFormFeedbackPartner'
        ]); ?>
    </div>
    */ ?>

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

    <div class="partner-formbox">
    </div>
</div>
<div class="one-cont double-cont map-cont contact-mapbox">
    <?= MainPartnerMap::widget(['id' => $mainPartner->id, 'city' => Yii::$app->city->getCity()]) ?>
</div>
<!-- end main partner -->

<?php /*FormFeedback::widget([
    'partner_id' => $mainPartner->id,
    'view' => 'form_feedback_partner_popup'
]); */ ?>
