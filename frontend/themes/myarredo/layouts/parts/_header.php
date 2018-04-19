<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\widgets\menu\CatalogMenu;
use frontend\modules\shop\widgets\cart\Cart;
use frontend\modules\location\widgets\ChangeCity;

?>

<header style="display: none;">

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

<div class="header">
    <div class="container-wrap">
        <?php if ((Yii::$app->getUser()->isGuest)): ?>
            <div class="top-header">
            <div class="container large-container">
                <div class="left-part">
                    <a href="#" class="phone-num">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <div>
                            <span class="phone">+7 (495) 150-21-21</span>
                            <span class="descr">Бесплатно по всей России</span>
                        </div>
                    </a>
                    <a href="#" class="back-call">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        Обрантый звонок
                    </a>
                    <div class="select-city">
                        <a href="javscript:void(0)" class="js-select-city">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            Россия | Москва
                        </a>
                        <div class="city-list-cont">
                            <ul class="links-cont">
                                <li><a href="http://almetevsk.myarredo.ru">Альметьевск</a></li>
                                <li><a href="http://anapa.myarredo.ru">Анапа</a></li>
                                <li><a href="http://barnaul.myarredo.ru">Барнаул</a></li>
                                <li><a href="http://belgorod.myarredo.ru">Белгород</a></li>
                                <li><a href="http://blagoveshchensk.myarredo.ru">Благовещенск</a></li>
                                <li><a href="http://bryansk.myarredo.ru">Брянск</a></li>
                                <li><a href="http://vladivostok.myarredo.ru">Владивосток</a></li>
                                <li><a href="http://vladikavkaz.myarredo.ru">Владикавказ</a></li>
                                <li><a href="http://vladimir.myarredo.ru">Владимир</a></li>
                                <li><a href="http://volgograd.myarredo.ru">Волгоград</a></li>
                                <li><a href="http://ekaterinburg.myarredo.ru">Екатеринбург</a></li>
                                <li><a href="http://irkutsk.myarredo.ru">Иркутск</a></li>
                                <li><a href="http://kazan.myarredo.ru">Казань</a></li>
                                <li><a href="http://kaluga.myarredo.ru">Калуга</a></li>
                                <li><a href="http://kemerovo.myarredo.ru">Кемерово</a></li>
                                <li><a href="http://kirov.myarredo.ru">Киров</a></li>
                                <li><a href="http://kostroma.myarredo.ru">Кострома</a></li>
                                <li><a href="http://krasnodar.myarredo.ru">Краснодар</a></li>
                                <li><a href="http://krasnoyarsk.myarredo.ru">Красноярск</a></li>
                                <li><a href="http://kursk.myarredo.ru">Курск</a></li>
                                <li><a href="http://magnitogorsk.myarredo.ru">Магнитогорск</a></li>
                                <li><a href="http://mahachkala.myarredo.ru">Махачкала</a></li>
                                <li class="active"><a href="http://www.myarredo.ru">Москва</a></li>
                                <li><a href="http://murmansk.myarredo.ru">Мурманск</a></li>
                                <li><a href="http://naberezhnye-chelny.myarredo.ru">Набережные Челны</a></li>
                                <li><a href="http://nalchik.myarredo.ru">Нальчик</a></li>
                                <li><a href="http://nn.myarredo.ru">Нижний Новгород</a></li>
                                <li><a href="http://novokuznetsk.myarredo.ru">Новокузнецк</a></li>
                                <li><a href="http://novorossiysk.myarredo.ru">Новороссийск</a></li>
                                <li><a href="http://novosibirsk.myarredo.ru">Новосибирск</a></li>
                                <li><a href="http://penza.myarredo.ru">Пенза</a></li>
                                <li><a href="http://perm.myarredo.ru">Пермь</a></li>
                                <li><a href="http://rnd.myarredo.ru">Ростов-на-Дону </a></li>
                                <li><a href="http://ryazan.myarredo.ru">Рязань</a></li>
                                <li><a href="http://samara.myarredo.ru">Самара</a></li>
                                <li><a href="http://spb.myarredo.ru">Санкт-Петербург</a></li>
                                <li><a href="http://saratov.myarredo.ru">Саратов</a></li>
                                <li><a href="http://sevastopol.myarredo.ru">Севастополь</a></li>
                                <li><a href="http://simferopol.myarredo.ru">Симферополь</a></li>
                                <li><a href="http://smolensk.myarredo.ru">Смоленск</a></li>
                                <li><a href="http://sochi.myarredo.ru">Сочи</a></li>
                                <li><a href="http://stavropol.myarredo.ru">Ставрополь</a></li>
                                <li><a href="http://taganrog.myarredo.ru">Таганрог</a></li>
                                <li><a href="http://tambov.myarredo.ru">Тамбов</a></li>
                                <li><a href="http://tolyatti.myarredo.ru">Тольятти</a></li>
                                <li><a href="http://tula.myarredo.ru">Тула</a></li>
                                <li><a href="http://tumen.myarredo.ru">Тюмень</a></li>
                                <li><a href="http://ulyanovsk.myarredo.ru">Ульяновск</a></li>
                                <li><a href="http://ufa.myarredo.ru">Уфа</a></li>
                                <li><a href="http://khabarovsk.myarredo.ru">Хабаровск</a></li>
                                <li><a href="http://chegem.myarredo.ru">Чегем</a></li>
                                <li><a href="http://chelyabinsk.myarredo.ru">Челябинск</a></li>
                                <li><a href="http://yaroslavl.myarredo.ru">Ярославль</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="lang-selector">
                        <a href="javascript:void(0);" class="js-select-lang">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            Рус
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <ul class="lang-drop-down">
                            <li>
                                <a href="#">
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                    Eng
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                    It
                                </a>
                            </li>
                        </ul>
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
                    <a href="#" class="wishlist">
                        <i class="fa fa-heart" aria-hidden="true"></i> Избранное
                    </a>
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
            <a href="#" class="logo">
                <img src="<?= $bundle->baseUrl ?>/img/logo.svg" alt="">
            </a>
            <div class="phone-container">
                <a href="#" class="phone-num">
                    +7 (495) 150-21-21
                </a>
                <div class="after-num">
                    Бесплатно по всей России
                </div>
            </div>
        </div>
    </div>
    <div class="right-btn-part">
        <div class="menu-btn">
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
                Обратный звонок
            </a>
            <a href="javascript:void(0);" class="close-mobile-menu">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
        </div>
        <a href="#" class="wishlist-mobile">
            <i class="fa fa-heart" aria-hidden="true"></i>
            Избранное
        </a>
        <ul class="menu-list">
            <li>
                <a href="#">КАТАЛОГ МЕБЕЛИ</a>
            </li>
            <li>
                <a href="#">ФАБРИКИ</a>
            </li>
            <li>
                <a href="#">РАСПРОДАЖА</a>
            </li>
            <li>
                <a href="#">О ПРОЕКТЕ</a>
            </li>
            <li>
                <a href="#">КОНТАКТЫ В МОСКВЕ</a>
            </li>
        </ul>
        <a href="#" class="logo-container">
            <img src="public/img/logo-odis.png" alt="">
        </a>
        <div class="bot-list">
            <div class="one-list-cont">
                <div class="one-list js-toggle-list">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    Россия | Москва
                </div>
                <?= ChangeCity::widget() ?>
            </div>
            <div class="one-list-cont js-toggle-list">
                <div class="one-list">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    Рус
                </div>
                <ul class="mobile-lang-list js-list-container">
                    <li>
                        <a href="#">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            Eng
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            It
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>