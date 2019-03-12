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
                <img src="<?= $bundle->baseUrl ?>/img/baner1.jpg" alt="">

                <div class="filter">

                    <?= ProductFilterOnMainPage::widget(); ?>

                </div>
            </div>

            <div class="best-price">
                <div class="container large-container">
                    <div class="section-header">
                        <div class="section-title">
                            <?= Yii::t('app', 'Как мы получаем лучшие цены для вас?') ?>
                        </div>
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
                                <?= Yii::t('app', 'Ваш запрос отправляется всем поставщикам, авторизированным в нашей сети MY ARREDO FAMILY.') ?>
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
                            <?= Yii::t('app', 'На нашем портале ведут рекламную кампанию сами фабрики. Салоны обеспечат сервис по покупки на фабрике и доставке клиенту по адресу.') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="categories-sect">
                <div class="container large-container">
                    <div class="section-header">

                        <?= Html::tag('h1', Yii::$app->metatag->seo_h1, ['class' => 'section-title']); ?>

                        <?= Html::a(
                            Yii::t('app', 'Смотреть все категории'),
                            Url::toRoute(['/catalog/category/list']),
                            ['class' => 'sticker']
                        ); ?>
                    </div>

                    <?= CategoryOnMainPage::widget(); ?>

                </div>
            </div>

            <?= SaleOnMainPage::widget(); ?>

            <?= ProductNovelty::widget(); ?>

            <div class="large-text">
                <div class="container large-container">
                    <div class="post-cont">

                        <?= Yii::$app->metatag->seo_content; ?>

                    </div>
                </div>
            </div>

        </div>

    </div>

</main>

<?= $content ?>

<?php $this->endContent(); ?>
