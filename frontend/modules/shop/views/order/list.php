<?php

use frontend\themes\defaults\assets\AppAsset;
//
use yii\helpers\{
    Html, Url
};

$bundle = AppAsset::register($this);

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">
            <h1>Заявки</h1>
            <!--
            <form class="form-filter-date-cont flex">
                <div class="dropdown arr-drop">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Россия</button>
                    <ul class="dropdown-menu drop-down-find">
                        <li>
                            <input type="text" class="find">
                        </li>
                        <li>
                            <a href="#">Россия</a>
                        </li>
                        <li>
                            <a href="#">Украина</a>
                        </li>
                        <li>
                            <a href="#">Беларусь</a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown arr-drop">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите
                        город
                    </button>
                    <ul class="dropdown-menu drop-down-find">
                        <li>
                            <input type="text" class="find">
                        </li>
                        <li>
                            <a href="#">Киев</a>
                        </li>
                        <li>
                            <a href="#">Днепр</a>
                        </li>
                        <li>
                            <a href="#">Харьков</a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown large-picker">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">21.08.2017 -
                        21.08.2017
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">
                                Oggi
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Leri
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Settimana
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                30 giorni
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Messe attuale
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Mese precedente
                            </a>
                        </li>
                        <li>
                            <a href="#"></a>
                        </li>
                    </ul>
                </div>
            </form>
            -->
            <div class="manager-history">
                <div class="manager-history-header">
                    <ul class="orders-title-block flex">
                        <li class="order-id">
                            <span>№</span>
                        </li>
                        <li class="application-date">
                            <span>Дата</span>
                        </li>
                        <li>
                            <span>Город</span>
                        </li>
                        <li>
                            <span><?= Yii::t('app', 'Status') ?></span>
                        </li>
                    </ul>
                </div>
                <div class="manager-history-list">

                    <?php if (!empty($orders)): ?>

                        <?php foreach ($orders as $order): ?>
                            <div class="item">
                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>
                                            <?= Html::a($order->id, Url::to(['/shop/order/view', 'id' => $order->id])) ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $order->getCreatedTime() ?></span>
                                    </li>
                                    <li><span>Москва</span></li>
                                    <li><span><?= $order['order_status'] ?></span></li>
                                </ul>
                            </div>
                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</main>