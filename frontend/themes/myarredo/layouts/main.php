<?php

use yii\helpers\{
    Html, Url
};

use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\menu\widgets\menu\Menu;

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
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <![endif]-->
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
                <a href="/" class="logo">
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
                        <li class="active"><?= Html::a(
                                'Каталог мебели',
                                Url::toRoute(['/catalog/category/list'])
                            ); ?></li>
                        <li><?= Html::a(
                                'Фабрики',
                                Url::toRoute(['/catalog/factory/list'])
                            ); ?></li>
                        <li><?= Html::a(
                            'Распродажа',
                            Url::toRoute(['/catalog/sale/list'])
                            ); ?></li>
                        <li><?= Html::a(
                                'О проекте',
                                Url::toRoute(['/page/page/view', 'alias' => 'about'])
                            ); ?></li>
                        <li><?= Html::a(
                                'Контакты в москве',
                                Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
                            ); ?></li>
                    </ul>

                </div>
            </div>
        </nav>

    </header>

    <?= $content ?>

    <footer>
        <div class="container large-container">
            <div class="row">
                <div class="col-md-4 center">

                    <?= Menu::widget(['alias' => 'footer']) ?>

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

                    <?= \frontend\modules\user\widgets\topBarInfo\topBarInfo::widget() ?>

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

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>