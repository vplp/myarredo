<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\modules\catalog\models\Factory;
use frontend\themes\myarredo\assets\AppAsset;

$bundle = AppAsset::register($this);

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<main>
    <div class="prod-card-page page">
        <div class="container large-container">
            <div class="row">
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
                <div class="product-title">
                    <h1 class="prod-model"><?= $model->getFullTitle(); ?></h1>
                </div>
                <div class="col-md-5">
                    <div id="prod-slider" class="carousel slide carousel-fade" data-ride="carousel">
                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/prod_thumb1.png" alt="">
                                </div>
                            </div>
                            <div class="item">
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/prod_thumb2.png" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- Carousel nav -->
                        <div class="nav-cont">
                            <a class="left left-arr nav-contr" href="#prod-slider" data-slide="prev">&lsaquo;</a>
                            <ol class="carousel-indicators">
                                <li data-target="#carousel" data-slide-to="0" class="active">
                                    <div class="img-min">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/prod_thumb1.png" alt="">
                                    </div>
                                </li>
                                <li data-target="#carousel" data-slide-to="1">
                                    <div class="img-min">
                                        <img src="<?= $bundle->baseUrl ?>/img/pictures/prod_thumb2.png" alt="">
                                    </div>
                                </li>
                            </ol>
                            <a class="right right-arr nav-contr" href="#prod-slider" data-slide="next">&rsaquo;</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="prod-info-table">
                        <table class="info-table">
                            <?php if (!$model['removed']): ?>
                                <tr class="price">
                                    <td>ЦЕНА ОТ:</td>
                                    <td><?= $model['price_from']; ?>&nbsp;<span class="currency">€</span>*</td>
                                </tr>
                            <?php endif; ?>
                            <tr class="availability">
                                <td>Наличие</td>
                                <td><?= ($model['removed']) ? 'Снят с протзводства' : 'Под заказ' ?></td>
                            </tr>
                            <tr>
                                <td>Стиль</td>
                                <td>
                                    <?php
                                    $array = [];
                                    foreach ($model['specificationValue'] as $item): ?>
                                        <?php if ($item['specification']['parent_id'] == 9): ?>
                                            <?php $array[] = $item['specification']['lang']['title']; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?= implode('; ', $array); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Фабрика</td>
                                <td>
                                    <?= Html::a(
                                        $model['factory']['lang']['title'],
                                        Factory::getUrl($model['factory']['alias'])
                                    ); ?>
                                </td>
                            </tr>

                            <?php if ($model['collections_id']): ?>
                                <tr>
                                    <td>Коллекция</td>
                                    <td>
                                        <?= Html::a(
                                            $model['collection']['lang']['title'],
                                            Yii::$app->catalogFilter->createUrl(['collection' => $model['collection']['id']])
                                        ); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php if (!$model['is_composition']): ?>
                                <tr>
                                    <td>Артикул</td>
                                    <td><?= $model['article']; ?></td>
                                </tr>
                                <tr>
                                    <td>Размеры</td>
                                    <td class="size">
                                        <?php foreach ($model['specificationValue'] as $item): ?>
                                            <?php if ($item['specification']['parent_id'] == 4): ?>
                                                <?= Html::beginTag('span'); ?>
                                                <?= $item['specification']['alias']; ?>:<?= $item['val']; ?>
                                                <?= Html::endTag('span'); ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Материал</td>
                                    <td>
                                        <?php
                                        $array = [];
                                        foreach ($model['specificationValue'] as $item): ?>
                                            <?php if ($item['specification']['parent_id'] == 2): ?>
                                                <?php $array[] = $item['specification']['lang']['title']; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?= implode('; ', $array); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </table>
                        <div class="prod-descr"><?= $model['lang']['description']; ?></div>
                    </div>
                </div>
                <div class="col-md-3">

                    <?php if (!$model['removed']): ?>
                        <div class="best-price-form">
                            <h3>
                                Заполните форму - получите лучшую цену на этот товар
                            </h3>
                            <form role="form">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" placeholder="Введите email">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" placeholder="Имя">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="phone" placeholder="+7 (___) ___-__-__">
                                </div>
                                <div class="form-group">
                                <textarea name="comm" class="form-control" id="" cols="30" rows="10"
                                          placeholder="Комментарии"></textarea>
                                </div>

                                <button type="submit" class="btn btn-success big">Получить лучшую цену</button>
                                <button type="submit" class="btn btn-default big">Отложить в блокнот</button>
                                <!--
                                <iframe src="https://www.google.com/recaptcha/api2/anchor?k=6LehPRkUAAAAAB1TVTLbwB1GYua9tI4aC1cHYSTU&co=aHR0cDovL3d3dy5teWFycmVkby5ydTo4MA..&hl=ru&v=r20170524165316&size=normal&cb=piye27zdt1ud" frameborder="0"></iframe>
                                -->
                            </form>
                        </div>
                    <?php else: ?>
                        Данный товар
                        снят с протзводства.
                        Но мы можем предложить
                        альтернативную модель.
                    <?php endif; ?>

                </div>
            </div>

            <div class="row composition">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <?php if ($model['is_composition']): ?>
                            <li><a data-toggle="tab" href="#panel1">ПРЕДМЕТЫ КОмпозиции</a></li>
                        <?php endif; ?>
                        <?php if (!empty($model['samples'])): ?>
                            <li><a data-toggle="tab" href="#panel2">ВАРИАНТЫ ОТДЕЛКИ</a></li>
                        <?php endif; ?>
                    </ul>

                    <div class="tab-content">

                        <?php if ($model['is_composition']): ?>
                            <div id="panel1" class="tab-pane fade">
                                <?= $this->render(
                                    'parts/_product_by_composition',
                                    [
                                        'models' => $model['compositionProduct']
                                    ]
                                ); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($model['samples'])): ?>
                            <div id="panel2" class="tab-pane fade">
                                <?= $this->render(
                                    'parts/_samples',
                                    [
                                        'samples' => $model['samples']
                                    ]
                                ); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="row receive-price">
                <h3>
                    Получите лучшую цену из всех, предложенных поставщиками!
                </h3>
                <h4>
                    Как мы получаем лучшие цены для Вас?
                </h4>
                <div class="order-cont">
                    <div class="one-ord">
                        <div class="number">
                            1
                        </div>
                        <div class="order-text">
                            Ваш запрос отправляется всем поставщикам,
                            авторизрованым в нашей сети MY ARREDO FAMILY.
                        </div>
                    </div>
                    <div class="one-ord">
                        <div class="number">
                            2
                        </div>
                        <div class="order-text">
                            Самые активные и успешные профессионалы
                            рассчитают для вас лучшие цены.
                        </div>
                    </div>
                    <div class="one-ord">
                        <div class="number">
                            3
                        </div>
                        <div class="order-text">
                            Вы получите 3 предложения и останется только выбрать
                            лучшее по цене и условиям. Экономьте время и усилия
                            на поиск по множеству сайтов.
                        </div>
                    </div>
                    <div class="one-ord">
                        <div class="number">
                            4
                        </div>
                        <div class="order-text">
                            Дополнительные скидки и бонусы от итальянскийх фабрик
                            участникам сети MY ARREDO FAMILY дают возможность
                            предоставить Вам самые привлекательные цены.
                        </div>
                    </div>
                    <div class="one-ord">
                        <div class="number">
                            5
                        </div>
                        <div class="order-text">
                            В сети MY ARREDO FAMILY только проверенные поставщики,
                            которые подтвердили свою надежность. Лучшие поставщики
                            итальянской мебели поборются за ваш заказ!
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!$model['removed']): ?>
                <div class="recommendation">
                    <div class="container large-container">
                        <h3 class="offer_title">Выберите любой понравившийся товар и получите на него лучшую цену!</h3>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/pictures/prod_thumb1.png" alt="">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="feedback-flex flex s-around">
                                    <div class="metr">Меня заинтересовал товар</div>
                                    <form role="form" class="flex-form">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="product"
                                                   value="Буфет Momenti Arte 0114" readonly>
                                        </div>
                                        <h4>Мои контактные данные:*</h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Имя">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="+7 (___) ___-__-__">
                                        </div>
                                        <button type="submit" class="btn btn-success">Жду лучшую цену</button>
                                    </form>
                                </div>
                                <div class="aft-text">Портал MyArredo гарантирует конфиденциальность личной информации
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($model['collections_id']): ?>

                <?= $this->render(
                    'parts/_product_by_collection',
                    [
                        'collection' => $model['collection'],
                        'models' => $model->getProductByCollection($model['collections_id'], $model['catalog_type_id'])
                    ]
                ); ?>

            <?php endif; ?>

            <?php if ($model['collections_id']): ?>

                <?= $this->render(
                    'parts/_product_by_factory',
                    [
                        'factory' => $model['factory'],
                        'types' => $model['types'],
                        'models' => $model->getProductByFactory($model['factory_id'], $model['catalog_type_id'])
                    ]
                ); ?>

            <?php endif; ?>

        </div>
    </div>
</main>
