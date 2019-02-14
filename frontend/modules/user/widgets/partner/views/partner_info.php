<?php

use yii\helpers\Html;
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);
?>

<?php
if (!Yii::$app->getUser()->isGuest &&
    in_array(Yii::$app->user->identity->group->role, ['partner', 'admin', 'factory'])
) { ?>
    <div class="ico">
        <img src="<?= $bundle->baseUrl ?>/img/phone.svg">
    </div>
    <p><?= Yii::t('app', 'Администрация проекта') ?></p>

    <?php
    if (Yii::$app->language == 'it-IT') {
        $phone = '+39 (0422) 150-02-15';
    } elseif (Yii::$app->city->domain == 'ua') {
        $phone = '+39 (0422) 150-02-15';
    } else {
        $phone = '+7 968 353 36 36';
    }
    $email = (Yii::$app->city->domain == 'ua') ? 'help@myarredo.ua' : 'help@myarredo.ru';
    ?>

    <p class="num"><?= $phone ?></p>
    <p class="num"><?= $email ?></p>
    <p class="num">skype: <?= Html::a('myarredo', 'skype:myarredo?chat') ?></p>

<?php } else { ?>
    <div class="ico">
        <img src="<?= $bundle->baseUrl ?>/img/phone.svg">
    </div>

    <meta itemprop="name" content="<?= Html::encode($partner['profile']['name_company']) ?>"/>

    <p><?= Yii::t('app', 'Получить консультацию в') ?> <?= $city['lang']['title_where'] ?></p>

    <p class="num" itemprop="telephone"><?= Yii::$app->partner->getPartnerPhone() ?></p>

    <?php /*if (Yii::$app->city->domain == 'ru') { ?>
        <p><?= Yii::t('app', 'Бесплатно в вашем городе') ?></p>
    <?php }*/ ?>

    <div class="ico">
        <img src="<?= $bundle->baseUrl ?>/img/marker-map.png">
    </div>

    <div class="stud" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <p><?= Html::encode($partner['profile']['name_company']) ?></p>
        <meta itemprop="addressLocality"
              content="<?= $city['country']['lang']['title'] ?> <?= $city['lang']['title'] ?>"/>
        <p><?= $city['lang']['title'] ?></p>
        <meta itemprop="streetAddress" content="<?= $partner['profile']['address'] ?></"/>
        <p><?= $partner['profile']['address'] ?></p>
        <p><?= $partner['profile']['phone'] ?></p>
    </div>

<?php } ?>