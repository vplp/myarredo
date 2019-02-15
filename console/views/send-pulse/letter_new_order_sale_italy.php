<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\ItalianProduct;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\shop\models\OrderItem */

?>

<div style="width:540px; font: 18px Arial,sans-serif;">
    <div style="background:#c4c0b8 url(https://www.myarredo.ru/uploads/mailer/logo_note.png) center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 18px Arial,sans-serif;">Мы помогаем продавать итальянскую мебель.</span>
    </div>
    <div style="text-align:center;">
        <p style="font-weight:bold;">
            НОВАЯ <a href="https://www.myarredo.<?= $order->city->country->alias ?>/partner/orders/">ЗАЯВКА</a>
            РАСПРОДАЖА С ИТАЛИИ НА САЙТЕ MYARREDO.<?= $order->city->country->alias ?>
            <span style="display:block;">Kлиент из г. <?= $order->city->lang->title ?></span>
        </p>

        <p>Клиента интересует следующая мебель:</p>

        <?php
        foreach ($order->items as $item) {
            echo Html::beginTag('p');

            if (ItalianProduct::isImage($item->product['image_link'])) {
                echo Html::img(
                    'https://www.myarredo.' . $order->city->country->alias . '/' . ItalianProduct::getImageThumb($item->product['image_link']),
                    ['class' => 'width: 140px; max-height: 100px;']
                );
            }

            echo Html::a(
                $item->product['lang']['title'],
                'https://www.myarredo.' . $order->city->country->alias . '/sale-italy-product/' . $item->product['alias'] . '/',
                ['style' => 'font-weight:bold; display: block; color: #000; text-transform: uppercase; text-decoration: underline;']
            );

            echo Html::endTag('p');
        }

        // phone
        $phone = ($order->city->country->alias == 'ua') ? '+39 (0422) 150-02-15' : '+7 968 353 36 36';
        ?>

        <div style="text-align: left; padding-left: 20px;">
            <p>Поторопитесь, возможность ответить есть только у первых 3 логистических компаний,
                далее заявка приобретает статус архивной,
                после чего ответить на заявку и получить контакты клиента будет невозможно.</p>
            <p>Напишите в комментариях к ответу:<br>
                - стоимость доставки до г. Москва, или стоимость доставки до города клиента<br>
                - сроки доставки<br>
                - помощь в оплате выбранной мебели в Италию</p>
            <p>Будьте доброжелательны к своим потенциальным клиентам!</p>
        </div>

        <p>Удачи в продажах!</p>

        <a href="https://www.myarredo.<?= $order->city->country->alias ?>/partner/orders/"
           style="text-decoration: none; color:#fff;">
            <div style="background-color:#00b05a; width: 80%; font-size: 18px; padding:20px; color: #fff; margin: 35px auto 20px; text-align: center;">
                <span style="display: block;">ПОЛУЧИТЬ КЛИЕНТА</span>
            </div>
        </a>
    </div>
    <div style="background-color:#c4c0b8; padding:15px 60px;">
        <span style="display: block; color: #000; font-style: italic; padding-bottom: 10px;">Телефон для связи с администрацией проекта</span>
        <span style="text-align: left; color: #0077ca; border-bottom: 1px dotted #0077ca;"><?= $phone ?></span>
    </div>
</div>