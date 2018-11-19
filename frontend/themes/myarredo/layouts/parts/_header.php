<?php

use yii\helpers\{
    Html, Url
};
use yii\bootstrap\ActiveForm;
//
use frontend\modules\sys\widgets\lang\LangSwitch;
use frontend\modules\catalog\widgets\menu\CatalogMenu;
use frontend\modules\catalog\widgets\menu_mobile\CatalogMenuMobile;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\location\widgets\ChangeCity;

?>

<div class="header js-fixed-header">
    <div class="container-wrap">

        <?php if ((Yii::$app->getUser()->isGuest)) { ?>
            <div class="top-header">
                <div class="container large-container">

                    <div class="left-part">
                        <?php /*if (!in_array(Yii::$app->controller->id, ['sale'])) { ?>
                            <a class="phone-num">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <div>
                                    <span class="phone"><?= Yii::$app->partner->getPartnerPhone() ?></span>
                                    <?php if (Yii::$app->city->domain == 'ru') { ?>
                                        <span class="descr">
                                            <?= Yii::t('app', 'Бесплатно в вашем городе') ?>
                                        </span>
                                    <?php } ?>
                                </div>
                            </a>
                        <?php }*/ ?>

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
        <?php } else { ?>
            <div class="top-header">
                <div class="container large-container">

                    <div class="left-part">
                        <div class="lang-selector">
                            <?= LangSwitch::widget() ?>
                        </div>
                    </div>

                    <div class="right-part">

                        <?php if (Yii::$app->getUser()->getIdentity()->group->role == 'user') { ?>
                            <?= Cart::widget(['view' => 'short']) ?>
                        <?php } ?>

                        <div class="sign-in">
                            <?php
                            $role = Yii::$app->getUser()->getIdentity()->group->role;
                            if ($role == 'partner') {
                                echo Yii::$app->getUser()->getIdentity()->profile->name_company;
                            } elseif ($role == 'admin') {
                                echo Yii::$app->getUser()->getIdentity()->profile->first_name;
                            } elseif ($role == 'factory') {
                                echo Yii::$app->getUser()->getIdentity()->profile->factory
                                    ? Yii::$app->getUser()->getIdentity()->profile->factory->title
                                    : '';
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

                                                <?php if (in_array(Yii::$app->getUser()->getIdentity()->group->role, ['partner'])) { ?>
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
                                                            Yii::t('app', 'Размещение кода'),
                                                            ['/page/page/view', 'alias' => 'razmeshchenie-koda']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Инструкция партнерам'),
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
                                                <?php } elseif (Yii::$app->getUser()->getIdentity()->group->role == 'admin') { ?>
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
                                                <?php } elseif (Yii::$app->getUser()->getIdentity()->group->role == 'factory') { ?>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'My goods'),
                                                            ['/catalog/factory-product/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Collections'),
                                                            ['/catalog/factory-collections/list']
                                                        ); ?>
                                                    </li>
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Рекламные кампании'),
                                                            ['/catalog/factory-promotion/list']
                                                        ); ?>
                                                    </li>
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
                                                    <?php
                                                    /*
                                                    <li>
                                                        <?= Html::a(
                                                            Yii::t('app', 'Banners'),
                                                            ['/banner/factory-banner/list']
                                                        ); ?>
                                                    </li>
                                                    */
                                                    ?>

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
                                                <?php } else { ?>
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
                                                <?php } ?>
                                            </ul>
                                        </object>
                                    </span>
                                </div>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>

        <?php } ?>

        <div class="bot-header">
            <div class="container large-container">

                <?= Html::a(
                    Html::img($bundle->baseUrl . '/img/logo.svg'),
                    Url::toRoute('/home/home/index'),
                    ['class' => 'logo']
                ) ?>

                <?php
                if (!Yii::$app->getUser()->isGuest &&
                    Yii::$app->getUser()->getIdentity()->group->role == 'factory'
                ) {
                } else { ?>
                    <?= CatalogMenu::widget([]); ?>

                    <div class="search-cont">
                        <?php $form = ActiveForm::begin([
                            'action' => ['/catalog/elastic-search/search'],
                            'method' => 'get',
                            'options' => ['class' => 'form-inline'],
                        ]); ?>

                        <div class="search-group">
                            <input id="search" name="search" placeholder="<?= Yii::t('app', 'Поиск') ?>"
                                   class="form-control input-md" required
                                   value="" type="text">
                            <?= Html::submitButton(
                                '<i class="fa fa-search" aria-hidden="true"></i>',
                                ['class' => 'search-button']
                            ) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                <?php } ?>

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
                <?php if (Yii::$app->city->domain == 'ru') { ?>
                    <div class="after-num">
                        <?= Yii::t('app', 'Бесплатно в вашем городе') ?>
                    </div>
                <?php } ?>
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

            <?php if ((Yii::$app->getUser()->isGuest)) { ?>
                <?= Html::a(
                    '<i class="fa fa-sign-in" aria-hidden="true"></i>' .
                    Yii::t('app', 'Sign In'),
                    ['/user/login/index'],
                    [
                        'class' => 'mobile-btn',
                        'rel' => 'nofollow'
                    ]
                ) ?>
            <?php } else { ?>
                <?= Html::a(
                    Yii::t('app', 'Sign Up'),
                    ['/user/logout/index'],
                    [
                        'class' => 'mobile-btn',
                        'rel' => 'nofollow'
                    ]
                ) ?>
            <?php } ?>

            <a class="back-call">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <?= Yii::t('app', 'Feedback form') ?>
            </a>

            <a href="javascript:void(0);" class="close-mobile-menu js-close-mobile-menu">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>

        </div>

        <?php
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->getUser()->getIdentity()->group->role == 'factory'
        ) {
        } else { ?>
            <?= CatalogMenuMobile::widget([]); ?>
        <?php } ?>

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