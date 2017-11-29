<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

/**
 * @var \frontend\modules\shop\models\Order $order
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= Html::tag('h1', $this->context->title); ?>

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
                            <span>Статус</span>
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
                                            <?= Html::a($order->id, $order->getPartnerOrderUrl()) ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $order->getCreatedTime() ?></span>
                                    </li>
                                    <li><span>Москва</span></li>
                                    <li><span><?= $order['order_status'] ?></span></li>
                                </ul>

                                <div class="hidden-order-info flex">
                                    <div class="hidden-order-in">
                                        <div class="flex-product">

                                            <?php
                                            foreach ($order->items as $item) {
                                                echo $this->render('_list_item', [
                                                    'item' => $item,
                                                ]);
                                            } ?>

                                        </div>
                                        <div class="form-wrap">

                                            <?php $form = ActiveForm::begin([
                                                'method' => 'post',
                                                'action' => $order->getPartnerOrderOnListUrl(),
                                                'id' => 'checkout-form',
                                            ]); ?>

                                            <?= $form->field($order->orderAnswer, 'answer')->textarea(['rows' => 5]) ?>

                                            <?= $form->field($order, 'comment')->textarea(['disabled' => true, 'rows' => 5]) ?>

                                            <?= $form->field($order->orderAnswer, 'results')->textarea(['rows' => 5]) ?>

                                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

                                            <?php ActiveForm::end(); ?>

                                        </div>


                                    </div>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</main>