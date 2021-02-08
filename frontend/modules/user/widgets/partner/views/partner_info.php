<?php

use yii\helpers\Html;
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\user\models\User;
use frontend\modules\location\models\City;

$bundle = AppAsset::register($this);

/** @var $partner User */
/** @var $city City */

$image_link = $partner['profile']['image_link']
    ? $partner['profile']['imageLink']
    : $bundle->baseUrl . '/img/cont-photo-bg.jpg';
?>

<div class="cont-info">
    <div class="cont-info-in">
        <div class="cont-info-border">
            <div class=""><?= Yii::t('app', 'Contacts') ?></div>

            <?php
            if (!Yii::$app->getUser()->isGuest &&
                in_array(Yii::$app->user->identity->group->role, ['partner', 'admin', 'factory', 'logistician'])
            ) { ?>
                <?php if ($this->beginCache('PartnerInfoUser' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) { ?>
                    <div class="ico">
                        <?= Html::img($bundle->baseUrl . '/img/phone.svg') ?>
                    </div>
                    <p><?= Yii::t('app', 'Администрация проекта') ?></p>

                    <?php
                    if (DOMAIN_TYPE == 'com') {
                        $phone = '+39 (0422) 150-02-15';
                    } elseif (DOMAIN_TYPE == 'ua') {
                        $phone = '+39 (0422) 150-02-15';
                    } else {
                        $phone = '+7 968 353 36 36';
                    }
                    $email = (DOMAIN_TYPE == 'ua') ? 'help@myarredo.ua' : 'help@myarredo.ru';
                    ?>

                    <p class="num"><?= $phone ?></p>
                    <p class="num"><?= $email ?></p>
                    <p class="num">skype: <?= Html::a('daniellalazareva123', 'skype:daniellalazareva123?chat') ?></p>

                    <?php $this->endCache();
                } ?>

            <?php } else { ?>

                <?php if ($this->beginCache('PartnerInfoUserGuest' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) { ?>
                    <div class="ico">
                        <?= Html::img($bundle->baseUrl . '/img/phone.svg') ?>
                    </div>

                    <meta itemprop="name" content="<?= Html::encode($partner['profile']->getNameCompany()) ?>"/>

                    <p><?= Yii::t('app', 'Получить консультацию в') ?> <?= $city['lang']['title_where'] ?></p>

                    <p class="num" itemprop="telephone"><?= Yii::$app->partner->getPartnerPhone() ?></p>

                    <div class="ico">
                        <?= Html::img($bundle->baseUrl . '/img/marker-map.png') ?>
                    </div>

                    <div class="stud" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                        <p><?= Html::encode($partner['profile']->getNameCompany()) ?></p>
                        <meta itemprop="addressLocality"
                              content="<?= $city['country']['lang']['title'] ?> <?= $city['lang']['title'] ?>"/>
                        <p><?= $city['lang']['title'] ?></p>
                        <meta itemprop="streetAddress" content="<?= $partner['profile']['lang']['address'] ?></"/>
                        <p><?= $partner['profile']['lang']['address'] ?></p>
                        <?php if ($partner['profile']['working_hours_start'] && $partner['profile']['working_hours_end']) { ?>
                            <p class="timework">
                                <span class="for-mode"><?= Yii::t('app', 'Режим работы салона') ?>:</span>
                                <span class="for-time"><?= $partner['profile']['working_hours_start'] ?> - <?= $partner['profile']['working_hours_end'] ?></span>
                            </p>
                        <?php } ?>
                    </div>

                    <?php $this->endCache();
                } ?>

            <?php } ?>

        </div>
    </div>
</div>

<div class="cont-bg custom-lazy" data-background="<?= $image_link ?>"></div>

