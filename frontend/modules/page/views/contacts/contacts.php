<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;

$this->title = $this->context->title;
$bundle = AppAsset::register($this);
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
                            <div class="one-cont double-cont">
                                <div class="img-part">
                                    <?= Html::img($bundle->baseUrl . '/img/cont1.svg') ?>
                                </div>
                                <div class="info-part">
                                    <div class="main-sticker">
                                        <?= Yii::t('app', 'Главный партнер') ?>
                                    </div>

                                    <?= Html::tag('h2', $mainPartner->profile->name_company); ?>

                                    <div class="ico">
                                        <?= Html::img($bundle->baseUrl . '/img/phone.svg') ?>
                                    </div>

                                    <?= Html::a(
                                        $mainPartner->profile->phone,
                                        'tel:' . $mainPartner->profile->phone,
                                        []
                                    ) ?>

                                    <div class="ico">
                                        <?= Html::img($bundle->baseUrl . '/img/marker-map.png') ?>
                                    </div>
                                    <div class="adres">
                                        <?= isset($mainPartner->profile->city) ? $mainPartner->profile->city->lang->title . '<br>' : '' ?>
                                        <?= $mainPartner->profile->address ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php foreach ($partners as $partner) { ?>
                            <div class="one-cont">
                                <?= Html::tag('h2', $partner->profile->name_company); ?>
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
                                    <?= isset($partner->profile->city) ? $partner->profile->city->lang->title . '<br>' : '' ?>
                                    <?= $partner->profile->address ?>
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
