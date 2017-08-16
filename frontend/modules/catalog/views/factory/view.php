<?php

use yii\helpers\{
    Url, Html
};
use yii\widgets\Breadcrumbs;
use frontend\modules\catalog\models\Factory;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 */

?>

<main>
    <div class="page factory-page">
        <div class="letter-nav">
            <div class="container large-container">
                <ul class="letter-select">

                    <?php foreach (Factory::getListLetters() as $letter): ?>
                        <li>
                            <?= Html::a(
                                $letter['first_letter'],
                                Url::toRoute(['/catalog/factory/list', 'letter' => strtolower($letter['first_letter'])])
                            ); ?>
                        </li>
                    <?php endforeach; ?>

                </ul>
                <?= Html::a('Все', Url::toRoute(['/catalog/factory/list']), ['class' => 'all']); ?>
            </div>
        </div>
        <div class="container large-container">
            <div class="row">
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
            </div>
            <div class="row factory-det">
                <div class="col-sm-3 col-md-3">
                    <div class="fact-img">
                        <img src="public/img/pictures/fact-det.png" alt="Логотип фабрики">
                    </div>
                </div>
                <div class="col-sm-9 col-md-9">
                    <div class="descr">
                        <h1 class="title-text"><?= $model['lang']['title']; ?></h1>
                        <div class="fact-link">
                            <?= Html::a($model['url'], 'http://' . $model['url'], ['target' => '_blank']); ?>
                        </div>
                        <div class="fact-assort">
                            <div class="all-list">
                                <a href="#" class="title">
                                    Все предметы мебели
                                </a>
                                <ul class="list">
                                    <li>
                                        <a href="#">
                                            Банкетка (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барная стойка (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стол (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стул (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Бра (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Буфет (23)
                                        </a>
                                    </li>
                                </ul>
                                <ul class="list post-list">
                                    <li>
                                        <a href="#">
                                            Банкетка (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барная стойка (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стол (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Барный стул (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Бра (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Буфет (23)
                                        </a>
                                    </li>
                                </ul>
                                <a href="javascript:void(0);" class="view-all">
                                    Весь список
                                </a>
                            </div>
                            <div class="all-list">
                                <a href="#" class="title">
                                    Все коллекции
                                </a>
                                <ul class="list">
                                    <li>
                                        <a href="#">
                                            AMADEUS (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            CELEBRITY (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            DOLCE VITA (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            EXSELCIOR (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            GRAND RYAL (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            HARMONY (23)
                                        </a>
                                    </li>
                                </ul>
                                <ul class="list post-list">
                                    <li>
                                        <a href="#">
                                            AMADEUS (3)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            CELEBRITY (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            DOLCE VITA (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            EXSELCIOR (2)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            GRAND RYAL (23)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            HARMONY (23)
                                        </a>
                                    </li>
                                </ul>
                                <a href="javascript:void(0);" class="view-all">
                                    Весь список
                                </a>

                            </div>
                        </div>
                        <div class="text">
                            <?= $model['lang']['content']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row menu-style">
                <a href="#">
                    Все
                </a>
                <a href="#">
                    Аксессуары
                </a>
                <a href="#">
                    Гостиные
                </a>
                <a href="#">
                    Кабинеты
                </a>
                <a href="#">
                    Кухни
                </a>
                <a href="#">
                    Мебель для TV
                </a>
                <a href="#">
                    Мебель для ресторанов
                </a>
                <a href="#">
                    Мягкая мебель
                </a>
                <a href="#">
                    Прихожие
                </a>
                <a href="#">
                    Светильники
                </a>
                <a href="#">
                    Спальни
                </a>
                <a href="#">
                    Столовые комнаты
                </a>
                <a href="#">
                    Стулья
                </a>
            </div>

            <div class="cat-prod catalog-wrap">
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat1.jpeg" alt="">
                        <div class="brand">
                            ANGELO CAPPELLINI
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat2.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>
                <a href="#" class="one-prod-tile">
                    <object>
                        <a href="javascript:void(0);" class="request-price">
                            Запросить цену
                        </a>
                    </object>
                    <div class="img-cont">
                        <img src="public/img/pictures/prod-cat3.jpg" alt="">
                        <div class="brand">
                            SAVIO FIRMINO
                        </div>
                    </div>
                    <div class="item-infoblock">
                        Спальный гарнитур BEDROOMS
                    </div>
                </a>

                <?= Html::a(
                    'смотреть полный<div>Каталог</div>',
                    Yii::$app->catalogFilter->createUrl('factory', $model['alias'], true),
                    ['class' => 'one-prod-tile last']
                ); ?>

            </div>


        </div>
    </div>
</main>
