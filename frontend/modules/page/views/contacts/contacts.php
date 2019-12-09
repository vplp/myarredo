<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;

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
                            echo $this->render('parts/_main_partner', [
                                'partners' => $partners
                            ]);
                        } else {
                            echo $this->render('parts/_no_main_partner', [
                                'partners' => $partners
                            ]);
                        }?>

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
