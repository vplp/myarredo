<?php

use yii\helpers\{
    Html, Url
};
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

$this->title = $this->context->title;

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>
                </div>
                <div class="col-md-12">
                    <p><?= Yii::t('app', 'Благодарим за обращение, Ваша заявка отправлена.') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="home-main">
        <div class="container-wrap">
            <!-- best-price -->
            <div class="best-price">
                <div class="container large-container">
                    <div class="numbers js-numbers">
                        <div class="one-number">
                            <div class="title">
                                1
                                <div class="img-cont">
                                    <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num1.svg" alt="номер 1"
                                         width="105" height="105"
                                         class="lazy">
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
                                    <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num2.svg" alt="номер 2"
                                         width="105" height="105"
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
                                    <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num3.svg" alt="номер 3"
                                         width="105" height="105"
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
                                    <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num4.svg" alt="номер 4"
                                         width="105" height="105"
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
                                    <img src="/" data-src="<?= $bundle->baseUrl ?>/img/num5.svg" alt="номер 5"
                                         width="105" height="105"
                                         class="lazy">
                                </div>
                            </div>
                            <div class="descr">
                                <?= Yii::t('app', 'В сети MY ARREDO FAMILY только проверенные поставщики, которые подтвердили свою надежность.') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end best-price -->

        </div>
    </div>
</main>
