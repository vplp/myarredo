<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\catalog\widgets\category\CategoryOnMainPage;
use frontend\modules\catalog\widgets\factory\FactoryOnMainPage;
use frontend\modules\catalog\widgets\product\ProductNovelty;
use frontend\modules\catalog\widgets\sale\SaleOnMainPage;
use frontend\modules\user\widgets\partner\PartnerMap;

$bundle = AppAsset::register($this);

?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<main>
    <div class="home-page">
        <div class="home-slidee-wrap">
            <div id="home-slider" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">
                    <div class="item active">
                        <a href="http://www.myarredo.ru/factory/nieri/">
                            <img src="<?= $bundle->baseUrl ?>/img/pictures/banner_1.png" alt="">
                        </a>
                    </div>
                    <div class="item">
                        <a href="http://www.myarredo.ru/factory/nieri/">
                            <img src="<?= $bundle->baseUrl ?>/img/pictures/banner_2.png" alt="">
                        </a>
                    </div>
                    <div class="item">
                        <a href="http://www.myarredo.ru/factory/nieri/">
                            <img src="<?= $bundle->baseUrl ?>/img/pictures/banner_3.png" alt="">
                        </a>
                    </div>
                    <div class="item">
                        <a href="http://www.myarredo.ru/factory/nieri/">
                            <img src="<?= $bundle->baseUrl ?>/img/pictures/banner_4.png" alt="">
                        </a>
                    </div>
                </div>

                <a class="left carousel-control" href="#home-slider" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#home-slider" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

            </div>

            <?php /*
            <div class="search-form flex c-align">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Название товара или фабрики">
                </div>
                <button type="button" class="btn btn-success">Найти</button>
            </div>
            */ ?>

        </div>

        <div class="container large-container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?= Html::tag('h1', $this->context->SeoH1); ?>
                </div>
            </div>
        </div>


        <?= CategoryOnMainPage::widget(); ?>

        <?= ProductNovelty::widget(); ?>

        <?= SaleOnMainPage::widget(); ?>

        <?php if (Yii::$app->language == 'ru-RU'): ?>
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
                                        Поставщик товаров из Италии в <?= Yii::$app->city->getCityTitleWhere() ?>
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

                            <?= Html::a(
                                'Перейти в каталог',
                                Url::toRoute('/catalog/category/list'),
                                ['class' => 'to-cat btn btn-default']
                            ); ?>

                        </div>

                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?= FactoryOnMainPage::widget(); ?>

        <div class="factories">
            <div class="container large-container">
                <div class="row">
                    <div class="text">
                        <?= $this->context->SeoContent; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (Yii::$app->language == 'ru-RU'): ?>
            <div class="manager-request">
                <div class="title">
                    <div class="quest">Не нашли что искали?</div>
                    <div class="sm-title">НАШ МЕНЕДЖЕР ПОДБЕРЕТ МЕБЕЛЬ ПО ВАШИМ ПАРАМЕТРАМ</div>

                    <?= Html::a(
                        'Контакты в ' . Yii::$app->city->getCityTitleWhere(),
                        Url::toRoute('/page/contacts/index'),
                        ['class' => 'btn btn-default']
                    ); ?>

                </div>
            </div>

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
                                            Когда увидела их сайт, их каталог, сразу же влюбилась. С помощью их
                                            менеджеров
                                            и дизайнеров мы подобрали самые лучшую мебель, которая очень хорошо
                                            вписалась
                                            в интерьер и сочеталась друг с другом. Все доставили, собрали – такой сервис
                                            отличный. Причем цены значительно ниже, чем в московских салонах с такой же
                                            итальянской мебелью.
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
        <?php endif; ?>

        <?= PartnerMap::widget(['city' => Yii::$app->city->getCity()]) ?>

    </div>

</main>

<?= $content ?>

<?php $this->endContent(); ?>
