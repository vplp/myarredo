<?php

use yii\helpers\{
    Html, Url
};
use yii\bootstrap\ActiveForm;
use frontend\modules\sys\widgets\lang\LangSwitch;
use frontend\modules\catalog\widgets\menu\CatalogMenu;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\location\widgets\{
    ChangeCity, ChangeCurrency
};
use frontend\modules\user\widgets\menu\UserMenu;

$clearPhoneNumb = preg_replace('/\D+/', '', Yii::$app->partner->getPartnerPhone());

?>

<!-- preloader start -->
<div id="preload_box" class="preloader-container" title="">
    <div class="preloaderbox">
        <div class="item-1"></div>
        <div class="item-2"></div>
        <div class="item-3"></div>
        <div class="item-4"></div>
        <div class="item-5"></div>
    </div>
</div>
<!-- preloader end -->

<div id="top" class="header js-fixed-header">
    <div class="container-wrap">

        <?php if ((Yii::$app->getUser()->isGuest)) { ?>
            <div class="top-header">
                <div class="container large-container">

                    <div class="left-part">
                        <?php if (!in_array(Yii::$app->city->domain, ['com', 'de']) && !in_array(Yii::$app->controller->id, ['sale', 'sale-italy'])) { ?>
                            <a href="tel:+<?= $clearPhoneNumb ?>" class="phone-num">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <div>
                                    <span class="phone"><?= Yii::$app->partner->getPartnerPhone() ?></span>
                                </div>
                            </a>
                        <?php } ?>

                        <?php /*
                        <a class="back-call">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <?= Yii::t('app', 'Feedback form') ?>
                        </a> */ ?>

                        <?php if (!in_array(Yii::$app->city->domain, ['com', 'de'])) { ?>
                            <div class="select-city">
                                <a href="javascript:void(0)" class="js-select-city">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <?= Yii::$app->city->getCountryTitle() ?> | <?= Yii::$app->city->getCitytitle() ?>
                                </a>
                                <div class="city-list-cont">
                                    <?= ChangeCity::widget() ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="lang-selector">
                            <?= LangSwitch::widget() ?>
                        </div>
                        <?php if (in_array(Yii::$app->city->domain, ['ru'])) { ?>
                            <div class="lang-selector">
                                <?= ChangeCurrency::widget() ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="right-part">

                        <?= Html::a(
                            '<i class="fa fa-user-o" aria-hidden="true"></i>' .
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
                        <?php if (in_array(Yii::$app->city->domain, ['ru'])) { ?>
                            <div class="lang-selector">
                                <?= ChangeCurrency::widget() ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="right-part">

                        <?php if (Yii::$app->user->identity->group->role == 'user') { ?>
                            <?= Cart::widget(['view' => 'short']) ?>
                        <?php } ?>

                        <div class="sign-in withicon">
                            <?php
                            echo Html::beginTag('a', ['href' => Url::toRoute('/user/profile/index')]);

                            $role = Yii::$app->user->identity->group->role;
                            if ($role == 'partner') {
                                echo Yii::$app->user->identity->profile->getNameCompany();
                            } elseif ($role == 'admin') {
                                echo Yii::$app->user->identity->profile->first_name;
                            } elseif ($role == 'factory') {
                                echo Yii::$app->user->identity->profile->factory
                                    ? Yii::$app->user->identity->profile->factory->title
                                    : '';
                            } else {
                                echo Yii::$app->user->identity->profile->first_name;
                            }
                            echo Html::endTag('a'); ?>
                        </div>

                        <?= UserMenu::widget(['view' => 'user_menu']); ?>

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

                <?php if (!Yii::$app->getUser()->isGuest &&
                    Yii::$app->user->identity->group->role == 'partner' &&
                    Yii::$app->user->identity->profile->country_id == 4) { ?>
                    <div class="header-addprodbox">
                        <?= Html::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Free add'),
                            Url::toRoute(['/catalog/italian-product/free-create']),
                            ['class' => 'btn-myarredo']
                        ) ?>
                    </div>
                <?php } ?>

                <?php if (!Yii::$app->getUser()->isGuest &&
                    (
                        (Yii::$app->user->identity->group->role == 'partner' && Yii::$app->user->identity->profile->country_id == 4) ||
                        Yii::$app->user->identity->group->role == 'factory'
                    )
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
                            <?= Html::input(
                                'text',
                                'search',
                                null,
                                [
                                    'class' => 'form-control input-md',
                                    'placeholder' => Yii::t('app', 'Поиск'),
                                ]
                            ) ?>
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
    <div class="left-info-part mobmenu-part">
        <div class="menu-btn js-menu-btn mobmenu-panel">
            <span class="for-mobmenu-barsicon"><i class="fa fa-bars" aria-hidden="true"></i></span>
            <span class="for-mob-menu-barstext">Меню</span>
        </div>
        <div class="logo-num">
            <a href="/" class="logo">
                <img src="<?= $bundle->baseUrl ?>/img/logo_myarredo.svg" alt="">
            </a>
        </div>
    </div>
    <div class="right-btn-part mobmenu-part">

        <!-- <div class="search-btn">
            <i class="fa fa-search" aria-hidden="true"></i>
        </div> -->
        <div class="adress-container">
            <div class="js-toggle-list">
                <span class="for-map-icon">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                </span>
                <span class="for-adress-icon"><?= Yii::$app->city->getCitytitle() ?></span>
            </div>
            <?= ChangeCity::widget(['view' => 'select_city_mobile']) ?>
        </div>

        <div class="mobmenu-right-box">
            <?php
            if ((Yii::$app->getUser()->isGuest)) {
                echo Html::a(
                    '<i class="fa fa-user-o" aria-hidden="true"></i>',
                    ['/user/login/index'],
                    ['class' => 'mobile-btn btn-siginout',
                        'rel' => 'nofollow']
                );
            } else {
                echo Html::a(
                    '<i class="fa fa-sign-out" aria-hidden="true"></i>',
                    ['/user/logout/index'],
                    ['class' => 'mobile-btn btn-siginout',
                        'rel' => 'nofollow']
                );
            } ?>

            <div class="mobmenu-wishlistbox">
                <?= Cart::widget(['view' => 'short']) ?>
            </div>
            <div class="mobmenu-fabrics">
                <a href="<?= Url::toRoute(['/catalog/factory/list']) ?>" class="mob-fabrics-link">
                    <span class="for-mobmenu-fabicon"><i class="fa fa-industry" aria-hidden="true"></i></span>
                    <span class="for-mobmenu-fabtext"><?= Yii::t('app', 'Фабрики') ?></span>

                </a>
            </div>
        </div>
    </div>
    <div class="mobmenu-bottom-part">
        <div class="feedback-container">
            <span class="for-fcicon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
            <span class="for-fctext"><?= Yii::t('app', 'Напишите нам') ?></span>
        </div>
        <div class="phone-container">
            <a href="tel:+<?= $clearPhoneNumb ?>" class="phone-num">
                <?= Yii::$app->partner->getPartnerPhone() ?>
            </a>
        </div>
    </div>
    <div class="mobmenu-serch-part">
        <?php $form = ActiveForm::begin(['action' => ['/catalog/elastic-search/search'],
            'method' => 'get',
            'options' => ['class' => 'mobsearch-form'],]); ?>

        <div class="mobsearch-group">
            <?= Html::input(
                'text',
                'search',
                null,
                ['class' => 'form-control mobsearch-fld',
                    'placeholder' => Yii::t('app', 'Поиск'),]
            ) ?>
            <?= Html::submitButton(
                '<i class="fa fa-search" aria-hidden="true"></i>',
                ['class' => 'btn-mobsearch']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="mobile-menu js-mobile-menu">
        <div class="stripe">

            <?php
            if ((Yii::$app->getUser()->isGuest)) {
                echo Html::a(
                    '<i class="fa fa-sign-in" aria-hidden="true"></i>' .
                    Yii::t('app', 'Sign In'),
                    ['/user/login/index'],
                    ['class' => 'mobile-btn',
                        'rel' => 'nofollow']
                );
            } else {
                echo Html::a(
                    Yii::t('app', 'Sign Up'),
                    ['/user/logout/index'],
                    ['class' => 'mobile-btn',
                        'rel' => 'nofollow']
                );
            } ?>

            <?= Html::a(
                '<i class="fa fa-phone" aria-hidden="true"></i>' . Yii::t('app', 'Feedback form'),
                'javascript:void(0);',
                [
                    'class' => 'back-call',
                    'data-toggle' => 'modal',
                    'data-target' => '#formFeedbackModal'
                ]
            ) ?>

            <a href="javascript:void(0);" class="close-mobile-menu js-close-mobile-menu">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </a>

        </div>

        <?php
        if (!Yii::$app->getUser()->isGuest &&
            Yii::$app->user->identity->group->role == 'factory'
        ) {
            echo UserMenu::widget(['view' => 'user_menu_mobile']);
        } else {
            echo UserMenu::widget(['view' => 'user_menu_mobile']);
            echo CatalogMenu::widget(['view' => 'catalog_menu_mobile']);
        } ?>

    </div>
</div>
<div class="mobile-openbg"></div>
