<?php

use yii\helpers\Html;

use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->beginPage()
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <base href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>">
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= $this->title ?></title>
        <link rel="shortcut icon" type="image/png" href="shortfavicon.png"/>
        <link rel="icon" type="image/png" href="favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->head(); ?>
    </head>
    <body class="html">
    <?php $this->beginBody() ?>

    <header>
        <div class="city-select-cont">
            <div class="container large-container">
                <div class="row">
                    <div class="top-panel">
                        <div class="top-panel-in">
                            <a href="javascript:void(0);" class="set-country">Россия</a>
                            <a href="javascript:void(0);" id="close-top">
                                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="title-city">Ваш город</div>
                        <div class="tab-country-content">
                            <ul class="links-cont">
                                <li class="active">
                                    <a href="#">Москва</a>
                                </li>
                                <li>
                                    <a href="#">Санкт-Петербург</a>
                                </li>
                                <li>
                                    <a href="#">Альметьевск</a>
                                </li>
                                <li>
                                    <a href="#">Анапа</a>
                                </li>
                                <li>
                                    <a href="#">Архангельск</a>
                                </li>
                                <li>
                                    <a href="#">Барнаул</a>
                                </li>
                                <li>
                                    <a href="#">Белгород</a>
                                </li>
                                <li>
                                    <a href="#">Благовещенск</a>
                                </li>
                                <li>
                                    <a href="#">Брянск</a>
                                </li>
                                <li>
                                    <a href="#">Владивосток</a>
                                </li>
                                <li>
                                    <a href="#">Владикавказ</a>
                                </li>
                                <li>
                                    <a href="#">Владимир</a>
                                </li>
                                <li>
                                    <a href="#">Волгоград</a>
                                </li>
                                <li>
                                    <a href="#">Воронеж</a>
                                </li>
                                <li>
                                    <a href="#">Екатеринбург</a>
                                </li>
                                <li>
                                    <a href="#">Иваново</a>
                                </li>
                                <li>
                                    <a href="#">Ижевск</a>
                                </li>
                                <li>
                                    <a href="#">Иркутск</a>
                                </li>
                                <li>
                                    <a href="#">Казань</a>
                                </li>
                                <li>
                                    <a href="#">Калининград</a>
                                </li>
                                <li>
                                    <a href="#">Калуга</a>
                                </li>
                                <li>
                                    <a href="#">Кемерово</a>
                                </li>
                                <li>
                                    <a href="#">Киров</a>
                                </li>
                                <li>
                                    <a href="#">Кострома</a>
                                </li>
                                <li>
                                    <a href="#">Краснодар</a>
                                </li>
                                <li>
                                    <a href="#">Курск</a>
                                </li>
                                <li>
                                    <a href="#">Магнитогорск</a>
                                </li>
                                <li>
                                    <a href="#">Махачкала</a>
                                </li>
                                <li>
                                    <a href="#">Мурманск</a>
                                </li>
                                <li>
                                    <a href="#">Набережные челны</a>
                                </li>
                                <li>
                                    <a href="#">Нальчик</a>
                                </li>
                                <li>
                                    <a href="#">Нижничй Новгород</a>
                                </li>
                                <li>
                                    <a href="#">Новокузнецк</a>
                                </li>
                                <li>
                                    <a href="#">Новороссийск</a>
                                </li>
                                <li>
                                    <a href="#">Новосибирск</a>
                                </li>
                                <li>
                                    <a href="#">Оренбург</a>
                                </li>
                                <li>
                                    <a href="#">Пенза</a>
                                </li>
                                <li>
                                    <a href="#">Перьм</a>
                                </li>
                                <li>
                                    <a href="#">Рязань</a>
                                </li>
                                <li>
                                    <a href="#">Ростов-на-Дону</a>
                                </li>
                                <li>
                                    <a href="#">Самара</a>
                                </li>
                                <li>
                                    <a href="#">Саратов</a>
                                </li>
                                <li>
                                    <a href="#">Смоленск</a>
                                </li>
                                <li>
                                    <a href="#">Сочи</a>
                                </li>
                                <li>
                                    <a href="#">Ставрополь</a>
                                </li>
                                <li>
                                    <a href="#">Таганрог</a>
                                </li>
                                <li>
                                    <a href="#">Тамбов</a>
                                </li>
                                <li>
                                    <a href="#">Тверь</a>
                                </li>
                                <li>
                                    <a href="#">Тольятти</a>
                                </li>
                                <li>
                                    <a href="#">Томск</a>
                                </li>
                                <li>
                                    <a href="#">Тула</a>
                                </li>
                                <li>
                                    <a href="#">Тюмень</a>
                                </li>
                                <li>
                                    <a href="#">Ульяновск</a>
                                </li>
                                <li>
                                    <a href="#">Уфа</a>
                                </li>
                                <li>
                                    <a href="#">Хабаровск</a>
                                </li>
                                <li>
                                    <a href="#">Чебоксары</a>
                                </li>
                                <li>
                                    <a href="#">Челябинск</a>
                                </li>
                                <li>
                                    <a href="#">Южно-Сахалинск</a>
                                </li>
                                <li>
                                    <a href="#">Ярославль</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-navbar">
            <div class="container large-container">
                <ul class="nav navbar-nav top-panel flex">
                    <li class="tel-num">
						<span>
							<i class="glyphicon glyphicon-earphone"></i> +7 (844) 297-45-97
						</span>
                    </li>
                    <li>
                        <a class="callback-trigger" href="javascript:void(0);">
							<span>
								Обратный звонок
							</span>
                        </a>
                    </li>
                    <li class="geo">
                        <a href="javascript: void(0);" id="select-city">
                            <i class="glyphicon glyphicon-map-marker"></i>
                            <span class="country">
								Россия
							</span>
                            <span class="city">
								Москва
							</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="my-notebook">
							<span class="red-but">
								<i class="glyphicon glyphicon-book"></i>
							</span>
                            <span class="inscription">
								Мой блокнот
							</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <nav class="navbar">
            <div class="container large-container">
                <a href="javascript:void(0);" class="logo">
                    <img src="<?= $bundle->baseUrl ?>/img/logo.png" alt="">
                </a>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main-menu" >
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Каталог мебели</a></li>
                        <li><a href="#">Фабрики</a></li>
                        <li><a href="#">Распродажа</a></li>
                        <li><a href="#">О проекте</a></li>
                        <li><a href="#">Контакты в москве</a></li>
                    </ul>

                </div>
            </div>
        </nav>

    </header>
    <main>
        <div class="home-page">
            <div class="home-slidee-wrap">
                <div id="home-slider" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="<?= $bundle->baseUrl ?>/img/pictures/thumb1.jpg" alt="Изображение слайда">
                        </div>
                        <div class="item">
                            <img src="<?= $bundle->baseUrl ?>/img/pictures/thumb2.png" alt="Изображение слайда">
                        </div>
                    </div>

                    <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>

                </div>

                <div class="search-form flex c-align">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Название товара или фабрики">
                    </div>
                    <button type="button" class="btn btn-success">Найти</button>
                </div>

            </div>

            <div class="italian-furn">
                <div class="container large-container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="header">
                                <h2>ИТАЛЬЯНСКАЯ МЕБЕЛЬ В МОСКВЕ</h2>
                                <a href="#" class="more">Смотреть все категории</a>
                            </div>
                            <div class="tiles-wrap">
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn1.png" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Кухни
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn2.png" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Кабинеты
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn3.jpg" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Мягкая мебель
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn4.jpg" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Гостинные
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn5.jpg" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Спальни
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn6.jpg" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Детская мебель
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn7.jpg" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Светильники
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3 one-cat">
                                    <a href="#">
                                        <div class="img-cont">
                                            <img src="<?= $bundle->baseUrl ?>/img/furn8.png" alt="Изображение категории">
                                        </div>
                                        <div class="descr">
                                            Детская мебель
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Новинки -->

            <div class="novelties">
                <div class="container large-container">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="header">
                                <h2>Новинки</h2>
                                <a href="#" class="more">Смотреть все категории</a>
                                <div id="novelties-slider" class="carousel slide" data-ride="carousel">

                                    <div class="carousel-inner">

                                        <div class="item active">
                                            <div class="item-in">
                                                <div class="left">
                                                    <a href="#" class="large">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="right">
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                    </a>
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                    </a>
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                    </a>
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                    </a>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="item">
                                            <div class="item-in">
                                                <div class="left">
                                                    <a href="#" class="large">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                    </a>
                                                </div>
                                                <div class="right">
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                    </a>
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                    </a>
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_2.jpg" alt="">
                                                    </a>
                                                    <a href="#" class="smaller">
                                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/new_1.jpg" alt="">
                                                    </a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="arr-cont">
                                        <a class="left left-arr" href="#novelties-slider" role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                        </a>
                                        <div class="indent"></div>
                                        <a class="right right-arr" href="#novelties-slider" role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- конец Новинки -->

            <!-- распродажа -->
            <div class="sale">
                <div class="container large-container">
                    <div class="row">
                        <div class="col-ms-12">
                            <div class="header">
                                <h2>Распродажа</h2>
                                <a href="#" class="more">Все акционные товары</a>
                                <div id="sale-slider" class="carousel slide" data-ride="carousel" data-interval="10000">

                                    <div class="carousel-inner">

                                        <div class="item active">
                                            <div class="item-in">
                                                <div class="left-side">
                                                    <a href="#" class="one-tile">
                                                        <div class="img-cont">
                                                            <img src="<?= $bundle->baseUrl ?>/img/pictures/sale_1.jpg" alt="" class="cont">
                                                        </div>
                                                        <div class="name">
                                                            "Old bar", art. 435/SMCF
                                                        </div>
                                                        <div class="old-price">14 320 EUR</div>
                                                        <div class="new-price">
                                                            10 320 EUR
                                                        </div>
                                                    </a>
                                                    <a href="#" class="one-tile">
                                                        <div class="img-cont">
                                                            <img src="<?= $bundle->baseUrl ?>/img/pictures/sale_2.jpg" alt="" class="cont">
                                                        </div>
                                                        <div class="name">
                                                            Пенал MAGGI MASSIMO
                                                        </div>
                                                        <div class="old-price">14 320 EUR</div>
                                                        <div class="new-price">
                                                            10 320 EUR
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="right-side">
                                                    <a href="#" class="one-tile">
                                                        <div class="img-cont">
                                                            <img src="<?= $bundle->baseUrl ?>/img/pictures/sale_3.jpg" alt="" class="cont">
                                                        </div>
                                                        <div class="name">
                                                            Кухня MAGGI MASSIMO
                                                        </div>
                                                        <div class="old-price">14 320 EUR</div>
                                                        <div class="new-price">
                                                            10 320 EUR
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item">
                                            <div class="item-in">
                                                <div class="left-side">
                                                    <a href="#" class="one-tile">
                                                        <div class="img-cont">
                                                            <img src="<?= $bundle->baseUrl ?>/img/pictures/sale_1.jpg" alt="" class="cont">
                                                        </div>
                                                        <div class="name">
                                                            "Old bar", art. 435/SMCF
                                                        </div>
                                                        <div class="old-price">14 320 EUR</div>
                                                        <div class="new-price">
                                                            10 320 EUR
                                                        </div>
                                                    </a>
                                                    <a href="#" class="one-tile">
                                                        <div class="img-cont">
                                                            <img src="<?= $bundle->baseUrl ?>/img/pictures/sale_2.jpg" alt="" class="cont">
                                                        </div>
                                                        <div class="name">
                                                            Пенал MAGGI MASSIMO
                                                        </div>
                                                        <div class="old-price">14 320 EUR</div>
                                                        <div class="new-price">
                                                            10 320 EUR
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="right-side">
                                                    <a href="#" class="one-tile">
                                                        <div class="img-cont">
                                                            <img src="<?= $bundle->baseUrl ?>/img/pictures/sale_3.jpg" alt="" class="cont">
                                                        </div>
                                                        <div class="name">
                                                            Кухня MAGGI MASSIMO
                                                        </div>
                                                        <div class="old-price">14 320 EUR</div>
                                                        <div class="new-price">
                                                            10 320 EUR
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="arr-cont">
                                        <a class="left left-arr" href="#sale-slider" role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                        </a>
                                        <div class="indent"></div>
                                        <a class="right right-arr" href="#sale-slider" role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- конец распродажа -->

            <!-- Причины выбрать нас -->
            <div class="causes">
                <div class="container large-container">
                    <div class="row">
                        <h2>3 причины выбрать нас</h2>
                        <div class="causes-in">

                            <div class="col-md-4">
                                <div class="one-cause">
                                    <div class="big sofa">
                                        65 735
                                    </div>
                                    <div class="descr">
                                        Товаров для интерьера из Италии
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="one-cause">
                                    <div class="big italy">
                                        Лучший
                                    </div>
                                    <div class="descr">
                                        Поставщик товаров из Италии в Москве
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="one-cause">
                                    <div class="big like">
                                        Сервис
                                    </div>
                                    <div class="descr">
                                        <ul>
                                            <li>Консультации</li>
                                            <li>Подбор</li>
                                            <li>Доставка</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="to-cat btn btn-default">
                                Перейти в каталог
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Конец причины выбрать нас -->

            <!-- Популярные фабрики -->
            <div class="popular-fabr">
                <div class="container large-container">
                    <div class="row">
                        <h2>Популярные итальянские фабрики</h2>
                        <div class="fabr-cont">
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr1.jpg" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        VENETA CUCINE
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr2.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        ARCA
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr3.jpg" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        Angelo cappellini
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr4.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        FLEXFORM
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr5.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        VISIONNAIRE (IPE CAVALLI)
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr6.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        PORADA
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr7.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        TOMASSI CUCINE
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr8.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        TURRI SRL
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr9.gif" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        MODENESE GASTONE
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr10.jpg" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        TWILS (VENETA CUSCINI)
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr11.png" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        MASIERO (EMME PI LIGHT)
                                    </div>
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3 one-fabr">
                                <a href="#">
                                    <div class="img-fabr">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/fabr12.jpg" alt="Лоотип фабрики">
                                    </div>
                                    <div class="descr">
                                        STILE LEGNO
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Конец популярные фабрики -->

            <!-- факторы -->
            <div class="factories">
                <div class="container large-container">
                    <div class="row">
                        <div class="text">
                            <p>
                                Вот уже много десятилетий лет <b>итальянская мебель</b> не просто не теряет своей актуальности,
                                но и уверенно лидирует в списках приобретений самых взыскательных и капризных клиентов.
                                <b>Итальянская мебель</b> – это гармоничное сочетание роскоши и практичности, изысканности,
                                неординарности и, вместе с тем, неповторимой эстетичности, стиля и изящества. Не стоит
                                также забывать про такие важные для современного потребителя свойства,
                                как эргономичность, комфорт, функциональность и главное разные ценовые сегменты.
                            </p>
                            <p>
                                Все эти преимущества в едином сочетании – вот главное преимущество, которым
                                отличается <b>элитная мебель из Италии</b> от множества аналогов от производителей из других стран.
                                <b>Элитная мебель</b> Италии всегда занимала особенное место в сердцах любителей прекрасного.
                                С её помощью легко преображать помещения любого типа, а сами изделия подчас настолько
                                изысканы, что с легкостью могут тягаться с произведениями искусства.
                                Италия – признанный лидер в производстве авторских моделей мебели, а итальянская мебель
                                уже не первое столетние задает тон мебельной моде всего прогрессивного мира.
                            </p>
                            <p>
                                Сколько бы ни прошло времени (речь идет о годах и даже десятилетиях),
                                итальянская мебель не теряет своей актуальности, спрос на нее остается по-прежнему
                                высоким и стабильным!
                            </p>
                            <p>
                                Порой, элитная мебель Италии несет в себе такие, казалось бы несовместимые на
                                первый взгляд качества, как способность сочетаться практически с любыми стилями оформления
                                интерьеров и в то же самое время – соответствие вековым традициям мебельной моды,
                                характерным для элитных гарнитуров и ансамблей. В оригинальных по дизайну и отделке предметах
                                мебели так просто и без излишней «пафосности», естественным и гармоничным образом могут
                                сочетаться неповторимый колорит и современные тенденции в мире мебельной моды.
                                Также можно упомянуть такое сочетание, как практичность и эргономичный дизайн с одной стороны,
                                а также роскошь и неповторимость – с другой.
                            </p>
                            <p>
                                Важно понимать, что элитная итальянская мебель – это не просто один из многочисленных
                                вариантов убранства вашего жилища, это выражение определенной психологии и философии жизни
                                ее владельцев, молчаливый показатель изысканного вкуса и финансового благосостояния.
                                Неспешно и с комфортом выбрать, а также купить итальянскую мебель для самых красивых и
                                эксклюзивных интерьеров в Москве.
                            </p>
                            <h2>
                                Почему стоит покупать итальянскую мебель
                            </h2>
                            <p>
                                Чтобы вы смогли ознакомиться с самыми актуальными предложениями любой салон итальянской
                                мебели  в Москве MYARREDO предоставит удобный каталог, в котором вы наверняка
                                сможете найти мебель вашей мечты. Менеджеры и дизайнеры пригласят в уютный
                                офис или салон, предложат в приятной атмосфере за чашечкой настоящего итальянского кофе
                                обсудить ваши пожелания, дадут наиболее полную консультацию по стилям, материалам и
                                всевозможным отделкам и конструкторским решениям. Мы предоставим лучшие цены и условия
                                покупки из всех предложений в Москве. С нашей помощью купить <b>итальянскую мебель</b> не только
                                просто но и приятно и выгодно.
                            </p>
                            <p>
                                Купить <b>итальянскую мебель</b> - лучший способ наполнить свое жилище уютом и придать ему
                                индивидуальности. Салон итальянской мебели сети Myarredo в Москве предлагает своим
                                клиентам в Москве стать обладателями уникальной мебели и предметов интерьера,
                                изготовленных на лучших фабриках и мебельных мастерских Италии. В нашем каталоге вы
                                сможете найти тысячи эксклюзивных предметов, которые помогут украсить ваше жилище и
                                сделают быт более изысканным и утонченным. Для получения подробной информации позвоните в
                                магазин итальянской мебели сети Myarredo в Москве по указанным контактным телефонам.
                                Всего пара кликов или один звонок и элитная мебель Италии украшает ваш дом.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- конец Факторы -->

            <!-- контакты в Москве -->
            <div class="manager-request">
                <div class="title">
                    <div class="quest">Не нашли что искали?</div>
                    <div class="sm-title">НАШ МЕНЕДЖЕР ПОДБЕРЕТ МЕБЕЛЬ ПО ВАШИМ ПАРАМЕТРАМ</div>
                    <a href="#" class="btn btn-default">
                        Контакты в Москве
                    </a>
                </div>
            </div>
            <!-- конец контакты в Москве -->

            <!-- Отзывы -->
            <div class="reviews">
                <div class="container large-container">
                    <div class="row">
                        <div id="reviews-slider" class="carousel slide" data-ride="carousel">

                            <div class="carousel-inner">
                                <div class="item active">
                                    <blockquote class="blockquote">
                                        <div class="quote">
                                            Я работаю дизайнером интерьером и мне часто приходится искать
                                            подходящую мебель для своих клиентов. Я просто обожаю салоны
                                            итальянской мебели myARREDO. Здесь представлен такой огромный ассортимент
                                            эксклюзивной, стильной и элегантной итальянской мебели!
                                            На мой взгляд, это лучший магазин, где можно приобрести итальянскую
                                            мебель. К тому же доставку и сборку осуществляют очень
                                            быстро и профессионально! Не могу менеджеров магазина не
                                            отметить – настоящие профессионалы своего дела!
                                        </div>
                                        <div class="signature">
                                            <span>ВЕРОНИКА</span> 15 ИЮЛЯ 2014
                                        </div>
                                    </blockquote>
                                </div>

                                <div class="item">
                                    <blockquote class="blockquote">
                                        <div class="quote">
                                            Почти всю мебель для нашего дома я заказывала в этом магазине.
                                            Когда увидела их сайт, их каталог, сразу же влюбилась. С помощью их менеджеров
                                            и дизайнеров мы подобрали самые лучшую мебель, которая очень хорошо вписалась
                                            в интерьер и сочеталась друг с другом. Все доставили, собрали – такой сервис
                                            отличный. Причем цены значительно ниже, чем в московских салонах с такой же итальянской мебелью.
                                        </div>
                                        <div class="signature">
                                            <span>ИРИНА</span> 17 ИЮЛЯ 2014
                                        </div>
                                    </blockquote>
                                </div>

                            </div>

                            <div class="arr-cont">
                                <a class="left left-arr" href="#reviews-slider" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <div class="indent"></div>
                                <a class="right right-arr" href="#reviews-slider" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- Конец Отзывы -->
            <div id="map"></div>

        </div>

    </main>
    <footer>
        <div class="container large-container">
            <div class="row">
                <div class="col-md-4 center">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="#">Главная</a>
                        </li>
                        <li>
                            <a href="#">О проекте</a>
                        </li>
                        <li>
                            <a href="#">СТатьи</a>
                        </li>
                        <li>
                            <a href="#">Фабрики</a>
                        </li>
                        <li>
                            <a href="#">Отзывы</a>
                        </li>
                        <li>
                            <a href="#">Карта сайта</a>
                        </li>
                        <li>
                            <a href="#">Регистрация партнера</a>
                        </li>
                        <li>
                            <a href="#">Как купить мебель из италии</a>
                        </li>
                        <li>
                            <a href="#">Контакты</a>
                        </li>

                    </ul>
                </div>
                <div class="col-md-4 center">
                    <div class="cons">Получить консультацию в Москве</div>
                    <div class="tel"><i class="fa fa-phone" aria-hidden="true"></i>+7 (499) 705-89-98</div>
                    <div class="stud">
                        Студия "СТАРЫЙ РИМ"</br>
                        Малый Харитоньевский переулок, 7с1
                    </div>
                    <a href="#" class="more">Посмотреть все офисы продаж</a>
                    <div class="social">
                        <a href="#">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 center">
                    <a href="" class="btn btn-transparent sign-in">
                        Вход в систему
                    </a>
                    <div class="copy">
                        <div class="copy-slogan">
                            2015 - 2017 (с) MyArredo, лучшая мебель из италии для вашего дома
                        </div>
                        <div class="fund">Программирование сайта - <a href="http://www.vipdesign.com.ua/">VipDesign</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="partner-cities container large-container">
            <div class="row">
                <div>
                    Этот список городов размещен здесь для вашего удобства.
                    Найдите свой город и купите итальянскую мебель по лучшей цене.
                </div>
                <ul>
                    <li><a href="#">Москва</a></li>
                    <li><a href="#">Санкт-Петербург</a></li>
                    <li><a href="#">Альметьевск</a></li>
                    <li><a href="#">Анапа</a></li>
                    <li><a href="#">Архангельск</a></li>
                    <li><a href="#">Барнаул</a></li>
                    <li><a href="#">Белгород</a></li>
                    <li><a href="#">Благовещенск</a></li>
                    <li><a href="http://bryansk.myarredo.ru/">Брянск</a></li>
                    <li><a href="http://vladivostok.myarredo.ru/">Владивосток</a></li>
                    <li><a href="http://vladikavkaz.myarredo.ru/">Владикавказ</a></li>
                    <li><a href="http://vladimir.myarredo.ru/">Владимир</a></li>
                    <li><a href="http://volgograd.myarredo.ru/">Волгоград</a></li>
                    <li><a href="http://voronezh.myarredo.ru/">Воронеж</a></li>
                    <li><a href="http://ekaterinburg.myarredo.ru/">Екатеринбург</a></li>
                    <li><a href="http://ivanovo.myarredo.ru/">Иваново</a></li>
                    <li><a href="http://izhevsk.myarredo.ru/">Ижевск</a></li>
                    <li><a href="http://irkutsk.myarredo.ru/">Иркутск</a></li>
                    <li><a href="http://kazan.myarredo.ru/">Казань</a></li>
                    <li><a href="http://kaliningrad.myarredo.ru/">Калининград</a></li>
                    <li><a href="http://kaluga.myarredo.ru/">Калуга</a></li>
                    <li><a href="http://kemerovo.myarredo.ru/">Кемерово</a></li>
                    <li><a href="http://kirov.myarredo.ru/">Киров</a></li>
                    <li><a href="http://kostroma.myarredo.ru/">Кострома</a></li>
                    <li><a href="http://krasnodar.myarredo.ru/">Краснодар</a></li>
                    <li><a href="http://krasnoyarsk.myarredo.ru/">Красноярск</a></li>
                    <li><a href="http://kursk.myarredo.ru/">Курск</a></li>
                    <li><a href="http://magnitogorsk.myarredo.ru/">Магнитогорск</a></li>
                    <li><a href="http://mahachkala.myarredo.ru/">Махачкала</a></li>
                    <li><a href="http://murmansk.myarredo.ru/">Мурманск</a></li>
                    <li><a href="http://naberezhnye-chelny.myarredo.ru/">Набережные Челны</a></li>
                    <li><a href="http://nalchik.myarredo.ru/">Нальчик</a></li>
                    <li><a href="http://nn.myarredo.ru/">Нижний Новгород</a></li>
                    <li><a href="http://novokuznetsk.myarredo.ru/">Новокузнецк</a></li>
                    <li><a href="http://novorossiysk.myarredo.ru/">Новороссийск</a></li>
                    <li><a href="http://novosibirsk.myarredo.ru/">Новосибирск</a></li>
                    <li><a href="http://orenburg.myarredo.ru/">Оренбург</a></li>
                    <li><a href="http://penza.myarredo.ru/">Пенза</a></li>
                    <li><a href="http://perm.myarredo.ru/">Пермь</a></li>
                    <li><a href="http://rnd.myarredo.ru/">Ростов-на-Дону </a></li>
                    <li><a href="http://ryazan.myarredo.ru/">Рязань</a></li>
                    <li><a href="http://samara.myarredo.ru/">Самара</a></li>
                    <li><a href="http://saratov.myarredo.ru/">Саратов</a></li>
                    <li><a href="http://sevastopol.myarredo.ru/">Севастополь</a></li>
                    <li><a href="http://simferopol.myarredo.ru/">Симферополь</a></li>
                    <li><a href="http://smolensk.myarredo.ru/">Смоленск</a></li>
                    <li><a href="http://sochi.myarredo.ru/">Сочи</a></li>
                    <li><a href="http://stavropol.myarredo.ru/">Ставрополь</a></li>
                    <li><a href="http://taganrog.myarredo.ru/">Таганрог</a></li>
                    <li><a href="http://tambov.myarredo.ru/">Тамбов</a></li>
                    <li><a href="http://tver.myarredo.ru/">Тверь</a></li>
                    <li><a href="http://tolyatti.myarredo.ru/">Тольятти</a></li>
                    <li><a href="http://tomsk.myarredo.ru/">Томск</a></li>
                    <li><a href="http://tula.myarredo.ru/">Тула</a></li>
                    <li><a href="http://tumen.myarredo.ru/">Тюмень</a></li>
                    <li><a href="http://ulyanovsk.myarredo.ru/">Ульяновск</a></li>
                    <li><a href="http://ufa.myarredo.ru/">Уфа</a></li>
                    <li><a href="http://khabarovsk.myarredo.ru/">Хабаровск</a></li>
                    <li><a href="http://cheboksary.myarredo.ru/">Чебоксары</a></li>
                    <li><a href="http://chelyabinsk.myarredo.ru/">Челябинск</a></li>
                    <li><a href="http://yuzhno-sakhalinsk.myarredo.ru/">Южно-Сахалинск</a></li>
                    <li><a href="http://yaroslavl.myarredo.ru/">Ярославль</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script async src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script>
        $(window).load(function(){
            ymaps.ready(function(){
                var map = new ymaps.Map("map", {
                    center: [55.73367, 37.587874],
                    zoom: 11,
                    scroll: false
                });
                map.behaviors.disable('scrollZoom');
            });
        });
    </script>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>