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

                    <?= $model['lang']['content'] ?>

                    <!-- top section start -->
                    <!-- <div class="presentsbox">
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
                    </div> -->
                    <!-- top section end -->

                    <!-- section Best price start -->
                    <!-- <div class="bestpricebox">
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
                    </div> -->
                    <!-- section Best price end -->

                    <!-- section offers start -->
                    <!-- <div class="offersbox">
                        <div class="about-content-box offers-topbox">
                            <div class="offers-leftbox">
                                <div class="about-offers-titlebox">
                                    <h2 class="about-titleh2">Что предлагает сеть myArredo family?</h2>
                                </div>
                            </div>
                            <div class="offers-rightbox">
                                <div class="mebel-decor-box">
                                    <img src="<?= $bundle->baseUrl ?>/img/about/mebel_decor.png" alt="Предложения">
                                </div>
                            </div>
                        </div>
                        <div class="about-content-box offers-gallerybox">
                            <div class="offers-gallery-item textbox-gallery1">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">1</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Проверенные салоны 
                                            продаж итальянской 
                                            мебели в более чем 70 
                                            городах России.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery2">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">2</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Электронный каталог myarredo.ru, в 
                                            котором легко подобрать любую мебель с  
                                            помощью разных фильтров даже неопытному пользователю.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery3">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">3</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Огромную базу каталогов и образцов (варианты тканей, дерева, покраски) в 
                                            салонах-партнерах сети.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery4">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">4</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Консультации опытных менеджеров, которые выслушав ваши пожелания 
                                            помогут не потеряться в разнообразии предлагаемых вариантов и выбрать нужный.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery5">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">5</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Лучшие цены и условия покупки.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery6">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">6</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Своевременную доставку в оговоренные сроки.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery7">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">7</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Профессиональную сборку, монтаж и установку.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery8">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">8</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            Консультации и услуги дизайнеров и архитекторов по 
                                            созданию и разработке проектов ваших интерьеров.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="offers-gallery-item textbox-gallery9">
                                <div class="offers-gallery-inner">
                                    <div class="gallery-item-textbox">
                                        <div class="gallery-textbox-icon">
                                            <span class="for-numb">9</span>
                                        </div>
                                        <p class="gallery-textbox-p">
                                            На портале myarredo.ru самая большая база распродажи в России, 
                                            если нет желания ждать мебель по и индивидуальному заказу.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- section offers end -->

                    <!-- section better-otchers start -->
                    <!-- <div class="better-otchersbox">
                        <div class="better-otchers-topbox">
                            <div class="betotchers-leftbox">
                                <div class="about-betotchers-titlebox">
                                    <h2 class="about-titleh2">Почему партнеры сети Myarredo family лучше других?</h2>
                                </div>
                            </div>
                            <div class="betotchers-rightbox">
                                <div class="betotchers-decorbox">
                                    <img src="<?= $bundle->baseUrl ?>/img/about/about_bg.png" alt="Лучше других">
                                </div>
                            </div>
                        </div>
                        <div class="better-otchers-iconbox">

                            <div class="betotchers-icon-item">
                                <div class="betotchers-icon-itembox">
                                    <div class="betotchers-iconitem-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best.png" alt="Опыт">
                                    </div>
                                    <div class="betotchers-iconitem-text">
                                        <b>1.</b> Средний возраст компаний
                                        парнеров <b>Myarredo Family</b> 
                                        9 лет. Это показатель 
                                        стабильности и опыта в деле
                                        обустройства вашего
                                        дома.
                                    </div>
                                </div>
                            </div>

                            <div class="betotchers-icon-item">
                                <div class="betotchers-icon-itembox">
                                    <div class="betotchers-iconitem-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best1.png" alt="Качество">
                                    </div>
                                    <div class="betotchers-iconitem-text">
                                        <b>2. Никаких подделок.</b> Все 
                                        наши партнеры работают 
                                        напрямую с итальянскими
                                        фабриками.
                                    </div>
                                </div>
                            </div>

                            <div class="betotchers-icon-item">
                                <div class="betotchers-icon-itembox">
                                    <div class="betotchers-iconitem-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best4.png" alt="Надежность">
                                    </div>
                                    <div class="betotchers-iconitem-text">
                                        <b>3.</b> Большинство партнеров
                                        сети рекомендованы 
                                        фабриками, как <b>надежные
                                        поставщики</b> зарекомендовавшие
                                        себя многолетним
                                        сотрудничеством.
                                    </div>
                                </div>
                            </div>

                            <div class="betotchers-icon-item">
                                <div class="betotchers-icon-itembox">
                                    <div class="betotchers-iconitem-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best3.png" alt="Безопастность">
                                    </div>
                                    <div class="betotchers-iconitem-text">
                                        <b>4. Ваши  права защищены.</b>
                                        Все наши партнеры 
                                        работают по договору
                                        и соблюдают Закон о
                                        защите прав потребителей.
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="better-otchers-blockbox">
                            <div class="about-content-box betotchers-blockbox">
                                <div class="betotchers-block-leftbox">
                                    <div class="block-leftbox-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best5.png" alt="Контроль качества">
                                    </div>
                                    <div class="block-leftbox-text">
                                        Служба контроля качества <b>Myarredo Family</b>  каждый месяц 
                                        проверяет, на сколько покупатели удовлетворены уровнем 
                                        обслуживания.
                                    </div>
                                </div>
                                <div class="betotchers-block-rightbox">
                                   <div class="block-rightbox-icon">
                                        <img src="<?= $bundle->baseUrl ?>/img/about/best6.png" alt="Обратная связь">
                                   </div> 
                                   <div class="block-rightbox-text">
                                        Если вы хотите похвалить кого-то из наших партнеров
                                        или пожаловаться - оставте свое сообщение.
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- section better-otchers end -->

                </div>
            </div>

        </div>
    </div>
</main>
