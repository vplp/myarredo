<?php

use frontend\themes\myarredo\assets\AppAsset;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\widgets\partner\PartnerMap;

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
                            $mainPartner = array_shift($partners);
                        ?>
                        <div class="one-cont double-cont">
                            <div class="img-part">
                                <img src="<?= $bundle->baseUrl ?>/img/cont1.svg" alt="">
                            </div>
                            <div class="info-part">
                                <div class="main-sticker">
                                    Главный партнер
                                </div>
                                <?= Html::tag('h4', $mainPartner->profile->name_company); ?>
                                <div class="ico">
                                    <img src="<?= $bundle->baseUrl ?>/img/phone.svg" alt="">
                                </div>
                                <a href="tel:<?= $mainPartner->profile->getPhone() ?>"><?= $mainPartner->profile->getPhone() ?></a>
                                <div class="ico">
                                    <img src="<?= $bundle->baseUrl ?>/img/marker-map.png" alt="">
                                </div>
                                <div class="adres">
                                    <?= $mainPartner->profile->address ?>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($partners as $partner): ?>
                            <div class="one-cont">
                                <?= Html::tag('h4', $partner->profile->name_company); ?>
                                <div class="ico">
                                    <img src="<?= $bundle->baseUrl ?>/img/phone.svg" alt="">
                                </div>
                                <a href="tel:<?= $partner->profile->getPhone() ?>"><?= $partner->profile->getPhone() ?></a>
                                <div class="ico">
                                    <img src="<?= $bundle->baseUrl ?>/img/marker-map.png" alt="">
                                </div>
                                <div class="adres">
                                    <?= $partner->profile->address ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <div class="warning">
                        * <?= Yii::t('app','Обращаем ваше внимание, цены партнеров сети могут отличаться.') ?>)
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>
