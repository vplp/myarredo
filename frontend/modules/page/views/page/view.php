<?php

use yii\helpers\Html;
//
use frontend\modules\page\models\Page;

use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

/**
 * @var $model Page
 */

$this->title = $this->context->title;

?>

<main class="about-main">
    <div class="about-wrap">
        <div class="largex-container about-container">
            <div class="aboutbox">
                <?= Html::tag('h1', Html::encode($model['lang']['title']), ['class' => 'about-title']); ?>
                <div class="about-content">

                    <!-- <?= $model['lang']['content'] ?> -->

                    <!-- top section start -->
                    <div class="presentsbox">
                        <div class="about-content-box">
                            <div class="about-presents-titlebox">
                                <h2 class="about-titleh2">Выбираете итальянскую мебель?</h2>
                            </div>
                        </div>
                    </div>
                    <div class="topiconsbox">
                        <div class="about-content-box topicons-itbox">

                            <div class="topicons-item">
                                <div class="topicons-item-box">
                                    <div class="topicons-item-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best_price.png" alt="Лучшие цены">
                                    </div>
                                    <div class="topicons-item-text">
                                        Получите лучшие 
                                        ценовые предложения 
                                        от проверенных 
                                        поставщиков 
                                        итальянской мебели 
                                        со всей России в один 
                                        клик!
                                    </div>
                                </div>
                            </div>

                            <div class="topicons-item">
                                <div class="topicons-item-box">
                                    <div class="topicons-item-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/salon_partner.png" alt="Салоны партнеры">
                                    </div>
                                    <div class="topicons-item-text">
                                        Салон-партнер сети 
                                        MY ARREDO FAMILY - это 
                                        гарантия лучшей цены 
                                        и качества 
                                        обслуживания!
                                    </div>
                                </div>
                            </div>

                            <div class="topicons-item">
                                <div class="topicons-item-box">
                                    <div class="topicons-item-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/select_mebel.png" alt="Выбор мебели">
                                    </div>
                                    <div class="topicons-item-text">
                                        В авторизованных 
                                        салонах-партнерах сети 
                                        MY ARREDO FAMILY 
                                        помогут подобрать 
                                        и купить итальянскую 
                                        мебель.
                                    </div>
                                </div>
                            </div>

                            <div class="topicons-item">
                                <div class="topicons-item-box">
                                    <div class="topicons-item-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/max_spectr.png" alt="Максимальный спектр">
                                    </div>
                                    <div class="topicons-item-text">
                                        Вам окажут  
                                        максимальный 
                                        спектр услуг, который 
                                        поможет превратить 
                                        выбор мебели в 
                                        приятный творческий
                                        процесс, а результат 
                                        будет радовать долгие 
                                        годы.
                                    </div>
                                </div>
                            </div>

                            <div class="topicons-item">
                                <div class="topicons-item-box">
                                    <div class="topicons-item-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/general_partner.png" alt="Главный партнер">
                                    </div>
                                    <div class="topicons-item-text">
                                        Выбирая главного 
                                        партнера  MY ARREDO 
                                        FAMILY вы получаете 
                                        гарантию 
                                        ответственного 
                                        поставщика.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- top section end -->

                    <!-- section Best price start -->
                    <div class="bestpricebox">
                        <div class="bestprice-leftbox">
                            <div class="about-bestprice-titlebox">
                                <h2 class="about-titleh2">Как мы получаем лучшие цены для Вас?</h2>
                            </div>
                        </div>
                        <div class="bestprice-rightbox">
                            <ul class="bestprice-list">
                                <li>
                                    <div class="bestprice-list-numberbox">
                                        <div class="list-number-box">
                                            <span class="for-numb">1</span>
                                            <span class="for-label">шаг</span>
                                        </div>
                                    </div>
                                    <div class="bestprice-list-textbox">
                                        Ваш запрос направляется 
                                        всем поставщикам, 
                                        авторизованным в нашей 
                                        сети MY ARREDO FAMILY.
                                    </div>
                                </li>
                                <li>
                                    <div class="bestprice-list-numberbox">
                                        <div class="list-number-box">
                                            <span class="for-numb">2</span>
                                            <span class="for-label">шаг</span>
                                        </div>
                                    </div>
                                    <div class="bestprice-list-textbox">
                                        Самые активные и успешные 
                                        профессионалы рассчитают 
                                        для вас лучшие цены
                                    </div>
                                </li>
                                <li>
                                    <div class="bestprice-list-numberbox">
                                        <div class="list-number-box">
                                            <span class="for-numb">3</span>
                                            <span class="for-label">шаг</span>
                                        </div>
                                    </div>
                                    <div class="bestprice-list-textbox">
                                        Вы получите предложения 
                                        и останется только выбрать 
                                        лучшее по цене и условиям. 
                                        Экономьте время и усилия на 
                                        поиск по множеству сайтов.
                                    </div>
                                </li>
                                <li>
                                    <div class="bestprice-list-numberbox">
                                        <div class="list-number-box">
                                            <span class="for-numb">4</span>
                                            <span class="for-label">шаг</span>
                                        </div>
                                    </div>
                                    <div class="bestprice-list-textbox">
                                        Дополнительные скидки и бонусы 
                                        от итальянских фабрик участникам 
                                        сети MY ARREDO FAMILY дают 
                                        возможность предоставить Вам 
                                        самые привлекательные цены.
                                    </div>
                                </li>
                                <li>
                                    <div class="bestprice-list-numberbox">
                                        <div class="list-number-box">
                                            <span class="for-numb">5</span>
                                            <span class="for-label">шаг</span>
                                        </div>
                                    </div>
                                    <div class="bestprice-list-textbox">
                                        Всего пара кликов и лучшие 
                                        поставщики итальянской 
                                        мебели поборются за ваш заказ!
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- section Best price end -->

                </div>
            </div>

        </div>
    </div>
</main>
