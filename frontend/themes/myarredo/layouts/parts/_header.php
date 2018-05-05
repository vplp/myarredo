<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\sys\widgets\lang\LangSwitch;
use frontend\modules\catalog\widgets\menu\CatalogMenu;
use frontend\modules\catalog\widgets\menu_mobile\CatalogMenuMobile;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\location\widgets\ChangeCity;

?>

<div class="header js-fixed-header">
    <div class="container-wrap">

        <?php if ((Yii::$app->getUser()->isGuest)): ?>

            <div class="top-header">
                <div class="container large-container">

                    <div class="left-part">
                        <a class="phone-num">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <div>
                                <span class="phone"><?= Yii::$app->partner->getPartnerPhone() ?></span>

                                <?php if (Yii::$app->city->domain == 'ru'): ?>
                                    <span class="descr">
                                    <?= Yii::t('app', 'Бесплатно по всей России') ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <?php /*
                        <a class="back-call">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <?= Yii::t('app', 'Feedback form') ?>
                        </a> */ ?>

                        <div class="select-city">
                            <a href="javascript:void(0)" class="js-select-city">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <?= Yii::$app->city->getCountryTitle() ?> | <?= Yii::$app->city->getCitytitle() ?>
                            </a>
                            <div class="city-list-cont">
                                <?= ChangeCity::widget() ?>
                            </div>
                        </div>

                        <div class="lang-selector">
                            <?= LangSwitch::widget() ?>
                        </div>

                        <?php /*
                        <a class="company-logo">
                            <img src="<?= $bundle->baseUrl ?>/img/logo-odis.png" alt="">
                        </a> */ ?>

                    </div>

                    <div class="right-part">

                        <?= Html::a(
                            '<i class="fa fa-sign-in" aria-hidden="true"></i>' .
                            Yii::t('app', 'Sign In'),
                            ['/user/login/index'],
                            [
                                'class' => 'sign-in',
                                'rel' => 'nofollow'
                            ]
                        ); ?>

                        <?= Cart::widget(['view' => 'short']) ?>

                    </div>

                </div>
            </div>

        <?php else: ?>

            <div class="top-header">
                <div class="container large-container">

                    <div class="left-part">
                        <div class="lang-selector">
                            <?= LangSwitch::widget() ?>
                        </div>
                    </div>

                    <div class="right-part">

                        <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'user'): ?>
                            <?= Cart::widget(['view' => 'short']) ?>
                        <?php endif; ?>

                        <div class="sign-in">
                            <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'partner') {
                                echo Yii::$app->getUser()->getIdentity()->profile->name_company;
                            } elseif (Yii::$app->getUser()->getIdentity()->group->role == 'admin') {
                                echo Yii::$app->getUser()->getIdentity()->profile->first_name;
                            } elseif (Yii::$app->getUser()->getIdentity()->group->role == 'factory') {
                                echo Yii::$app->getUser()->getIdentity()->profile->factory->title;
                            } else {
                                echo Yii::$app->getUser()->getIdentity()->profile->first_name;
                            } ?>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <div class="my-notebook dropdown">
                                    <span class="red-but notebook-but dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                        <?= Yii::t('app', 'Menu') ?>
                                        <object>
                                            <ul class="dropdown-menu">

                                                <?php if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['partner'])): ?>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Orders'),
                                                            ['/shop/partner-order/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Sale'),
                                                            ['/catalog/partner-sale/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            'Размещение кода',
                                                            ['/page/page/view', 'alias' => 'razmeshchenie-koda']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            'Инструкция партнерам',
                                                            ['/page/page/view', 'alias' => 'instructions']
                                                        ); ?>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Profile'),
                                                            ['/user/profile/index']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Sign Up'),
                                                            ['/user/logout/index']
                                                        ); ?>
                                                    </li>
                                                <?php elseif (Yii::$app->getUser()->getIdentity()->group->role == 'admin'): ?>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Orders'),
                                                            ['/shop/admin-order/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Product statistics'),
                                                            ['/catalog/product-stats/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Factory statistics'),
                                                            ['/catalog/factory-stats/list']
                                                        ); ?>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Profile'),
                                                            ['/user/profile/index']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Sign Up'),
                                                            ['/user/logout/index']
                                                        ); ?>
                                                    </li>
                                                <?php elseif (Yii::$app->getUser()->getIdentity()->group->role == 'factory'): ?>

                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Orders'),
                                                            ['/shop/factory-order/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Product statistics'),
                                                            ['/catalog/product-stats/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Factory statistics'),
                                                            ['/catalog/factory-stats/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Banners'),
                                                            ['/banner/factory-banner/list']
                                                        ); ?>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Profile'),
                                                            ['/user/profile/index']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Sign Up'),
                                                            ['/user/logout/index']
                                                        ); ?>
                                                    </li>

                                                <?php else: ?>

                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Orders'),
                                                            ['/shop/order/list']
                                                        ); ?>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Profile'),
                                                            ['/user/profile/index']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Sign Up'),
                                                            ['/user/logout/index']
                                                        ); ?>
                                                    </li>

                                                <?php endif; ?>
                                            </ul>
                                        </object>
                                    </span>
                                </div>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>

        <?php endif; ?>

        <div class="bot-header">
            <div class="container large-container">

                <?= Html::a(
                    Html::img($bundle->baseUrl . '/img/logo.svg'),
                    Url::toRoute('/home/home/index'),
                    ['class' => 'logo']
                ) ?>

                <?= CatalogMenu::widget([]); ?>

                <?php /*
                <div class="search-cont">
                    <form action="#">
                        <div class="search-group">
                            <input type="text" placeholder="Поиск">
                            <button class="search-button">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div> */ ?>

            </div>
        </div>
    </div>
</div>
<div class="mobile-header">
    <div class="left-info-part">
        <div class="logo-num">
            <a href="/" class="logo">
                <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
            </a>
            <div class="phone-container">
                <a class="phone-num">
                    <?= Yii::$app->partner->getPartnerPhone() ?>
                </a>
                <?php if (Yii::$app->city->domain == 'ru'): ?>
                    <div class="after-num">
                        <?= Yii::t('app', 'Бесплатно по всей России') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="right-btn-part">
        <div class="menu-btn js-menu-btn">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </div>
        <div class="search-btn">
            <i class="fa fa-search" aria-hidden="true"></i>
        </div>
    </div>

    <div class="mobile-menu js-mobile-menu">
        <div class="stripe">

            <?= Html::a(
                '<i class="fa fa-sign-in" aria-hidden="true"></i>' .
                Yii::t('app', 'Sign In'),
                ['/user/login/index'],
                [
                    'class' => 'mobile-btn'
                ]
            ); ?>

            <a class="back-call">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <?= Yii::t('app', 'Feedback form') ?>
            </a>

            <a href="javascript:void(0);" class="close-mobile-menu js-close-mobile-menu">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>

        </div>

        <!--
        <a class="wishlist-mobile">
            <i class="fa fa-heart" aria-hidden="true"></i>
            Избранное
        </a>
        -->

        <?= CatalogMenuMobile::widget([]); ?>

        <a class="logo-container">
            <img src="<?= $bundle->baseUrl ?>/img/logo-odis.png" alt="">
        </a>

        <div class="bot-list">
            <div class="one-list-cont">
                <div class="one-list js-toggle-list">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <?= Yii::$app->city->getCountryTitle() ?> | <?= Yii::$app->city->getCitytitle() ?>
                </div>

                <?= ChangeCity::widget(['view' => 'select_city_mobile']) ?>

            </div>
            <div class="one-list-cont">

                <?= LangSwitch::widget(['view' => 'lang_switch_mobile']) ?>

            </div>
        </div>
    </div>
</div>