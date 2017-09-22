<?php

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
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head(); ?>
        <input type="hidden" id="token" value="<?= Yii::$app->request->getCsrfToken() ?>">
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <![endif]-->
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= $this->render('parts/_header', ['bundle' => $bundle]) ?>

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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>