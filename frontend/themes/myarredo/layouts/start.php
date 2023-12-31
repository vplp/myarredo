<?php

use yii\helpers\{
    Html, Url
};
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\catalog\widgets\{
    category\CategoryOnMainPage,
    product\ProductsNoveltiesOnMain,
    sale\SaleOnMainPage,
    sale\SaleItalyOnMainPage
};
use frontend\modules\banner\widgets\BannerList;
use frontend\modules\articles\widgets\articles\ArticlesList;
use frontend\modules\news\widgets\newslist\NewsList;

$bundle = AppAsset::register($this);
?>

<?php $this->beginContent('@app/layouts/main.php'); ?>

<main>
    <!-- home-main -->
    <div class="home-main">


        <!-- container-wrap -->
        <div class="container-wrap">

            <?= BannerList::widget(['type' => 'main', 'city_id' => Yii::$app->city->getCityId()]); ?>

            <!-- best-price -->
            <div class="best-price">
                <div class="container large-container">
                    <div class="section-header">
                        <div class="section-title">
                            <?= Yii::t('app', 'Как мы получаем лучшие цены для вас?') ?>
                        </div>
                    </div>
                    <style type="text/css">
                        .home-main ul.slick-dots._nodisplay{
                            display: none !important;
                        }
                        @media (max-width:540px){
                            .section-numbers._start{
                                width: 100%;
                                overflow: hidden;
                            }
                            .numbers._start{
                                //width: 1920px;
                                //-ms-flex-wrap: nowrap;
                                //flex-wrap: nowrap;
                                height: 267px;
                            }
                            .one-number._start{
                                width: 97%;
                                height: 244px;
                            }
                            .home-main ul.slick-dots._start{
                                display: flex !important;
                            }
                        }
                    </style>
                    <?php echo "<pre style='display:none' 111111111111111111111111>";var_dump($bundle);echo "</pre>"; ?>
                    <div class="section-numbers _start">
                        <div class="numbers js-numbers _start">
                            <div class="one-number _start">
                                <div class="title">
                                    1
                                    <div class="img-cont">
                                        <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num1.svg" alt="номер 1" width="105" height="105"
                                             class="lazy">
                                    </div>
                                </div>
                                <div class="descr">
                                    <?= Yii::t('app', 'Ваш запрос отправляется всем поставщикам, авторизированным в нашей сети MY ARREDO FAMILY.') ?>
                                </div>
                            </div>
                            <ul class="slick-dots _start _nodisplay" role="tablist"><li class="slick-active" aria-hidden="false" role="presentation" aria-selected="true" aria-controls="navigation10" id="slick-slide10"><button type="button" data-role="none" role="button" tabindex="0">1</button></li><li aria-hidden="true" role="presentation" aria-selected="false" aria-controls="navigation11" id="slick-slide11" class=""><button type="button" data-role="none" role="button" tabindex="0">2</button></li><li aria-hidden="true" role="presentation" aria-selected="false" aria-controls="navigation12" id="slick-slide12"><button type="button" data-role="none" role="button" tabindex="0">3</button></li><li aria-hidden="true" role="presentation" aria-selected="false" aria-controls="navigation13" id="slick-slide13"><button type="button" data-role="none" role="button" tabindex="0">4</button></li><li aria-hidden="true" role="presentation" aria-selected="false" aria-controls="navigation14" id="slick-slide14"><button type="button" data-role="none" role="button" tabindex="0">5</button></li></ul>
                            <div class="one-number">
                                <div class="title">
                                    2
                                    <div class="img-cont">
                                        <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num2.svg" alt="номер 2" width="105" height="105"
                                             class="lazy">
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
                                        <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num3.svg" alt="номер 3" width="105" height="105"
                                             class="lazy">
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
                                        <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num4.svg" alt="номер 4" width="105" height="105"
                                             class="lazy">
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
                                        <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num5.svg" alt="номер 5" width="105" height="105"
                                             class="lazy">
                                    </div>
                                </div>
                                <div class="descr">
                                    <?= Yii::t('app', 'В сети MY ARREDO FAMILY только проверенные поставщики, которые подтвердили свою надежность.') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="after-text">
                        <div class="img-container">
                            <img src="/" data-src="<?= $bundle->baseUrl ?>/img/best-price.svg" alt="" width="270px"
                                 height="220x" class="lazy">
                        </div>
                        <div class="text-contain">
                            <?= Yii::t('app', 'На нашем портале ведут рекламную кампанию сами фабрики. Салоны обеспечат сервис по покупки на фабрике и доставке клиенту по адресу.') ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end best-price -->

            <?php //if ($this->beginCache('Start' . Yii::$app->city->getCityId() . Yii::$app->language, ['duration' => 7200])) { ?>
                <div class="categories-sect">
                    <div class="container large-container">
                        <div class="section-header">

                            <?= Html::tag('h1', Yii::$app->metatag->seo_h1, ['class' => 'section-title']); ?>

                            <?= Html::a(
                                Yii::t('app', 'Смотреть все категории'),
                                Url::toRoute(['/catalog/category/list']),
                                ['class' => 'sticker']
                            ) ?>
                        </div>

                        <?= CategoryOnMainPage::widget(); ?>

                    </div>
                </div>

                <?php if (DOMAIN_TYPE == 'com') {
                    echo SaleItalyOnMainPage::widget();
                } else {
                    echo SaleOnMainPage::widget();
                } ?>

                <?= ProductsNoveltiesOnMain::widget(); ?>

                <div class="large-text">
                    <div class="container large-container">
                        <div class="post-cont">

                            <?= Yii::$app->metatag->seo_content; ?>

                        </div>
                    </div>
                </div>

                <?= NewsList::widget(['view' => 'articles_on_main', 'limit' => 4]); ?>

                <?= ArticlesList::widget(['view' => 'articles_on_main', 'limit' => 4]); ?>

                <?php //$this->endCache(); } ?>

        </div>
        <!-- end container-wrap -->

    </div>
    <!-- end home-main -->

</main>

<?= $content ?>

<?php $this->endContent(); ?>
