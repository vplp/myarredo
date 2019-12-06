<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\user\widgets\partner\MainPartnerMap;
use frontend\modules\forms\widgets\FormFeedback;

$this->title = $this->context->title;
$bundle = AppAsset::register($this);


/** @var $partners array */
?>

<main>
    <div class="page concact-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="col-md-12">
                    <?= Html::tag('h1', $this->context->title); ?>
                    <div class="of-conts">
                        <?php
                        if ($partners[0]['profile']['partner_in_city']) {
                            $mainPartner = array_shift($partners);
                            ?>
                            <!-- main partner -->
                            <div class="one-cont double-cont">
                                <div class="top-mainpart">
                                    <div class="main-sticker">
                                        <?= Yii::t('app', 'Главный партнер') ?>
                                    </div>
                                    <?= Html::tag('h2', $mainPartner->profile->getNameCompany()); ?>

                                    <?php if ($mainPartner->profile->phone2) { ?>
                                        <div class="partner-phonebox">
                                            <span class="for-phone">Телефон:</span>
                                            <?= Html::a(
                                                $mainPartner->profile->phone2,
                                                'tel:' . $mainPartner->profile->phone2,
                                                []
                                            ); ?>
                                        </div>
                                        
                                    <?php } ?>
                                </div>

                                <div class="adress-mainpart">
                                    <div class="partner-adressbox">
                                        <div class="adres">
                                            <span class="for-adress">Адресс:</span>
                                                <?= isset($mainPartner->profile->city)
                                                    ? $mainPartner->profile->city->lang->title . '<br>'
                                                    : '' ?>
                                                <?= $mainPartner->profile->lang->address ?>
                                        </div>
                                        <div class="adres">
                                            <?= ($mainPartner->profile->working_hours_start && $mainPartner->profile->working_hours_end)
                                            ? '<span class="for-mode">Режим работы салона:</span>' . $mainPartner->profile->working_hours_start . ' - ' . $mainPartner->profile->working_hours_end
                                            : '' ?>
                                        </div>
                                    </div>
                                    <div class="partner-phonebox">
                                        <span class="for-phone">Телефон:</span>
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
                                                <span class="for-adress">Адресс:</span>
                                                <?= isset($mainPartner->profile->city)
                                                    ? $mainPartner->profile->city->lang->title . '<br>'
                                                    : '' ?>
                                                <?= $mainPartner->profile->lang->address2 ?>

                                            </div>

                                            <div class="adres">
                                                <?= ($mainPartner->profile->working_hours_start2 && $mainPartner->profile->working_hours_end2)
                                                    ? '<span class="for-mode">Режим работы салона:</span>' . $mainPartner->profile->working_hours_start2 . ' - ' . $mainPartner->profile->working_hours_end2
                                                    : '' ?>
                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>
                                

                                <div class="bottom-mainpart">
                                    <div class="partner-sitebox">
                                        <span class="for-site">Адресс сайта:</span>
                                        <?= Html::a(
                                            $mainPartner->profile->website,
                                            $mainPartner->profile->website,
                                            ['target' => '_blank', 'rel' => 'nofollow']
                                        ) ?>
                                    </div>
                                </div>

                                <div class="partner-formbox hidden">
                                    <?php /*echo FormFeedback::widget([
                                        'partner_id' => $mainPartner->id,
                                        'view' => 'form_feedback_partner'
                                    ]);*/ ?>
                                </div>
                            </div>
                            <div class="one-cont double-cont map-cont contact-mapbox">
                                <?= MainPartnerMap::widget(['id' => $mainPartner->id]) ?>
                            </div>
                            <!-- end main partner -->
                        <?php } ?>

                        <?php foreach ($partners as $partner) { ?>
                            <div class="one-cont">
                                <?= Html::tag('h2', $partner->profile->getNameCompany()); ?>
                                <div class="ico">
                                    <?= Html::img($bundle->baseUrl . '/img/phone.svg') ?>
                                </div>

                                <?= Html::a(
                                    $partner->profile->phone,
                                    'tel:' . $partner->profile->phone,
                                    []
                                ) ?>

                                <div class="ico">
                                    <?= Html::img($bundle->baseUrl . '/img/marker-map.png') ?>
                                </div>
                                <div class="adres">
                                    <?= isset($partner->profile->city)
                                        ? $partner->profile->city->lang->title . '<br>'
                                        : '' ?>
                                    <?= $partner->profile->lang->address ?? '' ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="warning">
                        * <?= Yii::t('app', 'Обращаем ваше внимание, цены партнеров сети могут отличаться.') ?>)
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>
