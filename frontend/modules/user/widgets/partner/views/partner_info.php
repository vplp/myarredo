<?php

use yii\helpers\Html;

?>

<?php if (
    !Yii::$app->getUser()->isGuest
    && in_array(Yii::$app->getUser()->getIdentity()->group->role, ['partner', 'admin', 'factory'])
): ?>

    <div class="cons"><?= Yii::t('app', 'Администрация проекта') ?></div>

    <?php
    $phone = (Yii::$app->city->domain == 'ua') ? '<span class="tel-num">+39 (0422) 150-02-15</span>' : '<span class="tel-num">+7 968 353 36 36</span>';
    $email = (Yii::$app->city->domain == 'ua') ? 'help@myarredo.ua' : 'help@myarredo.ru';
    ?>

    <div class="tel" itemprop="telephone">
        <i class="fa fa-phone" aria-hidden="true"></i><?= $phone ?>
    </div>

    <?php if (Yii::$app->city->domain == 'ru'): ?>
        <div class="after-tel-text"><?= Yii::t('app','Бесплатно по всей России') ?></div>
    <?php endif; ?>

    <div class="tel">
        <i class="fa" aria-hidden="true"></i><?= $email ?>
    </div>

    <div class="tel">
        <i class="fa" aria-hidden="true"></i>skype: <?= Html::a('myarredo', 'skype:myarredo?chat') ?>
    </div>

<?php elseif (Yii::$app->controller->id !== 'sale'): ?>

    <meta itemprop="name" content="<?= Html::encode($partner['profile']['name_company']) ?>"/>

    <div class="cons"><?= Yii::t('app', 'Получить консультацию в') ?> <?= $city['lang']['title_where'] ?></div>

    <div class="tel" itemprop="telephone">
        <i class="fa fa-phone" aria-hidden="true"></i><?= Yii::$app->partner->getPartnerPhone() ?>
    </div>

    <?php if (Yii::$app->city->domain == 'ru'): ?>
        <div class="after-tel-text"><?= Yii::t('app','Бесплатно по всей России') ?></div>
    <?php endif; ?>

    <div class="stud" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <meta itemprop="addressLocality"
              content="<?= $city['country']['lang']['title'] ?> <?= $city['lang']['title'] ?>"/>
        <meta itemprop="streetAddress" content="<?= $partner['profile']['address'] ?>"/>
        <?= $partner['profile']['name_company'] ?><br><?= $partner['profile']['address'] ?>
    </div>

<?php endif; ?>