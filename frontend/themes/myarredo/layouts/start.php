<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\themes\myarredo\assets\AppAsset;
//
use frontend\modules\catalog\widgets\{
    category\CategoryOnMainPage,
    product\ProductNovelty,
    sale\SaleOnMainPage,
    filter\ProductFilterOnMainPage
};

$bundle = AppAsset::register($this);
?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<main>
    <div class="home-main">
        <div class="container-wrap">
            <div class="top-home-img">
                <img src="<?= $bundle->baseUrl ?>/img/baner.jpg" alt="">

                <div class="filter">

                    <?= ProductFilterOnMainPage::widget(); ?>

                </div>
            </div>

            <div class="best-price">
                <div class="container large-container">
                    <div class="section-header">
                        <h3 class="section-title">
                            <?= Yii::t('app', 'Как мы получаем лучшие цены для вас?') ?>
                        </h3>

                    </div>
                    <div class="numbers js-numbers">
                        <div class="one-number">
                            <div class="title">
                                1
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/num1.svg" alt="">
                                </div>
                            </div>
                            <div class="descr">
                                <?= Yii::t('app', 'Ваш запрос отправляется всем поставщикам, авторизрованым в нашей сети MY ARREDO FAMILY.') ?>
                            </div>
                        </div>
                        <div class="one-number">
                            <div class="title">
                                2
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/num2.svg" alt="">
                                </div>
                            </div>
                            <div class="descr">
                                <?= Yii::t('app', 'Самые активные и успешные профессионалы рассчитают для вас лучшие цены.') ?>
                            </div>
                        </div>
                        <div class="one-number">
                            <div class="title">
                                3
                                <div class="img-cont" style="margin-top: 0;">
                                    <img src="<?= $bundle->baseUrl ?>/img/num3.svg" alt="">
                                </div>
                            </div>
                            <div class="descr">
                                <?= Yii::t('app', 'Вы получите предложения и останется только выбрать лучшее по цене и условиям.') ?>
                            </div>
                        </div>
                        <div class="one-number">
                            <div class="title">
                                4
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/num4.svg" alt="">
                                </div>
                            </div>
                            <div class="descr">
                                <?= Yii::t('app', 'Партнеры сети MY ARREDO FAMILY получают дополнительные скидки от фабрик и предоставляют лучшие цены Вам.') ?>
                            </div>
                        </div>
                        <div class="one-number">
                            <div class="title">
                                5
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/num5.svg" alt="">
                                </div>
                            </div>
                            <div class="descr">
                                <?= Yii::t('app', 'В сети MY ARREDO FAMILY только проверенные поставщики, которые подтвердили свою надежность.') ?>
                            </div>
                        </div>
                    </div>
                    <div class="after-text">
                        <div class="img-container">
                            <img src="<?= $bundle->baseUrl ?>/img/best-price.svg" alt="">
                        </div>
                        <div class="text-contain">
                            <?= Yii::t('app', 'На нашем портале ведут рекламную компанию сами фабрики. Салоны обеспечат сервис по покупки на фабрике и доставке клиенту по адресу.') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container large-container" style="display: none;">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?= Html::tag('h1', $this->context->SeoH1); ?>
                    </div>
                </div>
            </div>

            <?= CategoryOnMainPage::widget(); ?>

            <?= SaleOnMainPage::widget(); ?>

            <?= ProductNovelty::widget(); ?>

            <div class="large-text">
                <div class="container large-container">
                    <div class="post-cont">
                        <!--
                        <div class="one-post">
                            <div class="post-title">
                                <div class="post-title-in">
                                    Мебель – это  выражение
                                    определенной психологии
                                    и философии жизни
                                    ее владельцев
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="post-text">
                                    <p>Вот уже много десятилетий <i>итальянская мебель</i> не просто не
                                        теряет своей актуальности, но и уверенно лидирует в
                                        списках приобретений самых взыскательных и капризных
                                        клиентов. Итальянская мебель – это гармоничное сочетание
                                        роскоши и практичности, изысканности, неординарности и,
                                        вместе с тем, неповторимой эстетичности, стиля и изящества.
                                    </p>
                                    <p>
                                        Не стоит также забывать про такие важные для современного потребителя свойства
                                        , как эргономичность, комфорт, функциональность и главное разные ценовые сегменты.
                                        Все эти преимущества в едином сочетании – вот главное преимущество,
                                        которым отличается элитная мебель из Италии от множества аналогов
                                        от производителей из других стран. Элитная мебель Италии всегда
                                        занимала особенное место в сердцах любителей прекрасного.
                                    </p>
                                    <p>
                                        С её
                                        помощью легко преображать помещения любого типа, а сами изделия подчас
                                        настолько изысканы, что с легкостью могут тягаться с произведениями искусства.
                                        Италия – признанный лидер в производстве авторских моделей мебели, а <i>итальянская мебель</i>
                                        уже не первое столетние задает тон мебельной моде всего прогрессивного мира.
                                        Сколько бы ни прошло времени (речь идет о годах и даже десятилетиях),
                                        <i>итальянская мебель</i> не теряет своей актуальности, спрос на нее
                                        остается по-прежнему высоким и стабильным!
                                    </p>
                                    <p>
                                        Порой, элитная мебель Италии несет в себе такие, казалось
                                        бы несовместимые на первый взгляд качества, как способность сочетаться
                                        практически с любыми стилями оформления интерьеров и в то же
                                        самое время – соответствие вековым традициям мебельной моды,
                                        характерным для элитных гарнитуров и ансамблей.
                                    </p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="read-more js-read-more" data-variant="Свернуть">
                                        Читать дальше
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="one-post">
                            <div class="post-title">
                                <div class="post-title-in">
                                    Почему стоит покупать
                                    итальянскую мебель?
                                </div>
                            </div>
                            <div class="post-content">
                                <div class="post-text">
                                    <p>
                                        Чтобы вы смогли ознакомиться с самыми актуальными предложениями
                                        любой салон итальянской мебели в Москве MYARREDO предоставит
                                        удобный каталог, в котором вы наверняка сможете найти мебель
                                        вашей мечты. Менеджеры и дизайнеры пригласят в уютный офис или
                                        салон, предложат в приятной атмосфере за чашечкой настоящего
                                        итальянского кофе обсудить ваши пожелания, дадут наиболее полную
                                        консультацию по стилям, материалам и всевозможным отделкам
                                        и конструкторским решениям. Мы предоставим лучшие цены и условия
                                        покупки из всех предложений в Москве. С нашей помощью купить
                                        итальянскую мебель не только просто но и приятно и выгодно.
                                    </p>
                                    <p>
                                        Купить итальянскую мебель - лучший способ наполнить свое
                                        жилище уютом и придать ему индивидуальности. Салон итальянской
                                        мебели сети Myarredo в Москве предлагает своим клиентам в
                                        Москве стать обладателями уникальной мебели и предметов
                                        интерьера, изготовленных на лучших фабриках и мебельных
                                        мастерских Италии. В нашем каталоге вы сможете найти
                                        тысячи эксклюзивных предметов, которые помогут украсить ваше
                                        жилище и сделают быт более изысканным и утонченным. Для получения
                                        подробной информации позвоните в магазин итальянской мебели сети
                                        Myarredo в Москве по указанным контактным телефонам. Всего пара
                                        кликов или один звонок и элитная мебель Италии украшает ваш дом.
                                    </p>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="read-more js-read-more" data-variant="Свернуть">
                                        Читать дальше
                                    </a>
                                </div>
                            </div>
                        </div>
                        -->

                        <?= $this->context->SeoContent; ?>

                    </div>
                </div>
            </div>

        </div>

    </div>

</main>

<?= $content ?>

<?php $this->endContent(); ?>
