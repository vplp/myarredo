<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\widgets\menu\CatalogMenu;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\location\widgets\ChangeCity;

?>

<header>

    <?php if ((Yii::$app->getUser()->isGuest)): ?>

        <?= ChangeCity::widget() ?>

        <div class="top-navbar">
            <div class="container large-container">
                <div class="row">
                    <ul class="nav navbar-nav top-panel flex">
                        <li class="tel-num">
                            <span>
                                <i class="glyphicon glyphicon-earphone"></i> <?= Yii::$app->partner->getPartnerPhone() ?>
                            </span>
                            <?php if (Yii::$app->city->domain == 'ru'): ?>
                                <div><?= Yii::t('app','Бесплатно по всей России') ?></div>
                            <?php endif; ?>
                        </li>
                        <?php /*
                        <li>
                            <a class="callback-trigger" href="javascript:void(0);">
							<span>
								<?= Yii::t('app', 'Feedback form') ?>
							</span>
                            </a>
                        </li> */ ?>
                        <li class="geo">
                            <a href="javascript: void(0);" id="select-city">
                                <i class="glyphicon glyphicon-map-marker"></i>
                                <span class="country">
								    <?= Yii::$app->city->getCountryTitle() ?>
							    </span>
                                <span class="city">
								    <?= Yii::$app->city->getCitytitle() ?>
							    </span>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="short_cart">
                            <?= Cart::widget(['view' => 'short']) ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="top-navbar">
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
                                                    ['/catalog/product-stats/product']
                                                ); ?>
                                            </li>
                                            <li>
                                                <?= Html::a(
                                                    'Статистика по фабрике',
                                                    ['/catalog/product-stats/factory']
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
                                                    ['/catalog/product-stats/product']
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

    <nav class="navbar">
        <div class="container large-container">
            <div class="row">

                <?= Html::a(
                    Html::img($bundle->baseUrl . '/img/logo.svg'),
                    Url::toRoute('/home/home/index'),
                    ['class' => 'logo']
                ) ?>

                <?= CatalogMenu::widget([]); ?>
            </div>
        </div>
    </nav>
</header>