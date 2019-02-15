<?php

use yii\helpers\{
    Html, Url
};

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">
            <h1>Заявки</h1>

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

                    <?php
                    if (!empty($orders)) {
                        foreach ($orders as $order) { ?>
                            <div class="item">
                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>
                                            <?= Html::a(
                                                $order->id,
                                                Url::to(['/shop/order/view', 'id' => $order->id])
                                            ) ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $order->getCreatedTime() ?></span>
                                    </li>
                                    <li><span>Москва</span></li>
                                    <li><span><?= $order['order_status'] ?></span></li>
                                </ul>
                            </div>
                            <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
</main>