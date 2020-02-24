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
use frontend\modules\location\widgets\{
    ChangeCity, ChangeCurrency
};
use frontend\modules\user\widgets\menu\UserMenu;

?>

<!-- preloader start -->
<div id="preload_box" class="preloader-container" title="Подождите">
    <div class="preloaderbox">
        <div class="item-1"></div>
        <div class="item-2"></div>
        <div class="item-3"></div>
        <div class="item-4"></div>
        <div class="item-5"></div>
    </div>
</div>
<style>
    .preloader-container {
        position: fixed;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        /* background-image: linear-gradient(#448339, #45b431); */
        /* background-color: #F3F2F0; */
        background-color: rgba(243, 242, 240, 0.98);
        z-index: 9999;
    }

    .preloaderbox {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
        animation-delay: 1s;
    }

    .item-1 {
        width: 20px;
        height: 20px;
        background: #f583a1;
        border-radius: 50%;
        background-color: #eed968;
        margin: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50%,
        75% {
            transform: scale(2.5);
        }
        78%, 100% {
            opacity: 0;
        }
    }

    .item-1:before {
        content: '';
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #eed968;
        opacity: 0.7;
        animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
        animation-delay: 200ms;
        transition: 0.5s all ease;
        transform: scale(1);
    }

    .item-2 {
        width: 20px;
        height: 20px;
        background: #f583a1;
        border-radius: 50%;
        background-color: #eece68;
        margin: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50%,
        75% {
            transform: scale(2.5);
        }
        78%, 100% {
            opacity: 0;
        }
    }

    .item-2:before {
        content: '';
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #eece68;
        opacity: 0.7;
        animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
        animation-delay: 400ms;
        transition: 0.5s all ease;
        transform: scale(1);
    }

    .item-3 {
        width: 20px;
        height: 20px;
        background: #f583a1;
        border-radius: 50%;
        background-color: #eec368;
        margin: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50%,
        75% {
            transform: scale(2.5);
        }
        78%, 100% {
            opacity: 0;
        }
    }

    .item-3:before {
        content: '';
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #eec368;
        opacity: 0.7;
        animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
        animation-delay: 600ms;
        transition: 0.5s all ease;
        transform: scale(1);
    }

    .item-4 {
        width: 20px;
        height: 20px;
        background: #f583a1;
        border-radius: 50%;
        background-color: #eead68;
        margin: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50%,
        75% {
            transform: scale(2.5);
        }
        78%, 100% {
            opacity: 0;
        }
    }

    .item-4:before {
        content: '';
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #eead68;
        opacity: 0.7;
        animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
        animation-delay: 800ms;
        transition: 0.5s all ease;
        transform: scale(1);
    }

    .item-5 {
        width: 20px;
        height: 20px;
        background: #f583a1;
        border-radius: 50%;
        background-color: #ee8c68;
        margin: 7px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes scale {
        0% {
            transform: scale(1);
        }
        50%,
        75% {
            transform: scale(2.5);
        }
        78%, 100% {
            opacity: 0;
        }
    }

    .item-5:before {
        content: '';
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #ee8c68;
        opacity: 0.7;
        animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
        animation-delay: 1000ms;
        transition: 0.5s all ease;
        transform: scale(1);
    }
</style>
<!-- preloader end -->

<div id="top" class="header js-fixed-header">
    <div class="container-wrap">

        <?php if ((Yii::$app->getUser()->isGuest)) { ?>
            <div class="top-header">
                <div class="container large-container">

                    <div class="left-part">
                        <?php if (Yii::$app->city->domain != 'com' && !in_array(Yii::$app->controller->id, ['sale', 'sale-italy'])) { ?>
                            <a href="tel:<?= Yii::$app->partner->getPartnerPhone() ?>" class="phone-num">
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

                        <?php if (Yii::$app->city->domain != 'com') { ?>
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
                        <?= Html::a(
                            '<i class="fa fa-plus"></i> ' . Yii::t('app', 'Paid add'),
                            Url::toRoute(['/catalog/italian-product/paid-create']),
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
    <div class="left-info-part">
        <div class="logo-num">
            <a href="/" class="logo">
                <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
            </a>
            <div class="phone-container">
                <a href="tel:<?= Yii::$app->partner->getPartnerPhone() ?>" class="phone-num">
                    <?= Yii::$app->partner->getPartnerPhone() ?>
                </a>
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

    <div class="mobsearch-box">
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
                'Поиск',
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
            Yii::$app->user->identity->group->role == 'factory'
        ) {
            echo UserMenu::widget(['view' => 'user_menu_mobile']);
        } else {
            echo UserMenu::widget(['view' => 'user_menu_mobile']);
            echo CatalogMenuMobile::widget([]);
        } ?>

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

            <?php if (in_array(Yii::$app->city->domain, ['ru'])) { ?>
                <div class="one-list-cont">
                    <?= ChangeCurrency::widget(['view' => 'change_currency_mobile']) ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
