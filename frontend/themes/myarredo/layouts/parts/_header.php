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

<div class="header">
    <div class="container-wrap">

        <?php if ((Yii::$app->getUser()->isGuest)): ?>

            <div class="top-header">
                <div class="container large-container">
                    <div class="left-part">
                        <a href="#" class="phone-num">
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
                        <a href="javascript:void(0);" class="back-call">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <?= Yii::t('app', 'Feedback form') ?>
                        </a>
                        <div class="select-city">
                            <a href="javscript:void(0)" class="js-select-city">
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
                        <a href="#" class="company-logo">
                            <img src="<?= $bundle->baseUrl ?>/img/logo-odis.png" alt="">
                        </a>

                    </div>
                    <div class="right-part">
                        <a href="#" class="sign-in">
                            <i class="fa fa-sign-in" aria-hidden="true"></i>
                            Вход
                        </a>
                        <?= Cart::widget(['view' => 'short']) ?>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <div class="top-header">
                <div class="container large-container">
                    <div class="row">
                        <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'user'): ?>
                            <ul class="nav navbar-nav navbar-right">
                                <li id="short_cart">
                                    <?= Cart::widget(['view' => 'short']) ?>
                                </li>
                            </ul>
                        <?php endif; ?>

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
                                                    Yii::t('app', 'Statistics'),
                                                    ['/catalog/product-stats/list']
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
                                                    Yii::t('app', 'Statistics'),
                                                    ['/catalog/product-stats/list']
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
                <div class="search-cont">
                    <form action="#">
                        <div class="search-group">
                            <input type="text" placeholder="Поиск">
                            <button class="search-button">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </form>
                </div>
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
                <a href="#" class="phone-num">
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
            <a href="javascript:void(0);" class="mobile-btn">
                <i class="fa fa-sign-in" aria-hidden="true"></i>
                Вход
            </a>
            <a href="javascript:void(0);" class="back-call">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <?= Yii::t('app', 'Feedback form') ?>
            </a>
            <a href="javascript:void(0);" class="close-mobile-menu js-close-mobile-menu">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
        </div>
        <a href="#" class="wishlist-mobile">
            <i class="fa fa-heart" aria-hidden="true"></i>
            Избранное
        </a>

        <?= CatalogMenuMobile::widget([]); ?>

        <a href="/" class="logo-container">
            <img src="public/img/logo-odis.png" alt="">
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