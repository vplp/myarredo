<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\CartItem */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('http://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">Мы помогаем купить итальянскую мебель по лучшим ценам.</span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p style="font-size: 16px;">Здравствуйте, <?= $order->customer['full_name'] ?></p>
        <p style="font-size: 13px; color: #591612;">Ваш запрос <span
                    style="font-weight: bold; color: #000;">№<?= $order['id'] ?></span> успешно принят.</p>
        <p style="font-size: 14px; color: #000;">Вам прийдут письма с ценами на предметы, которые Вас заинтересовали от
            разных поставщиков.</p>
        <p style="font-size: 14px; color: #000;">Вам нужно будет только выбрать лучшие условия для покупки.</p>
        <p style="font-size: 14px; color: #000; margin-top:25px;">Просчет занимает от 15 мнут до 1 рабочего дня.</p>
    </div>

    <div style="background-color:#fff; padding:20px; clear: both; display: block;">
        <p style="color: #591612; font-size: 15px;">Запрошенные товары</p>

        <?php foreach ($order->items as $item): ?>
            <div style="clear: both; height: 100px;">
                <div style="float: left;">

                    <?= Html::img(
                        'http://www.myarredo.' . $order->city->country->alias . Product::getImageThumb($item->product['image_link']),
                        ['class' => 'width: 140px; max-height: 100px;']
                    ); ?>

                </div>
                <div style="float: left; margin: 10px 30px;">

                    <?= Html::a(
                        $item->product['lang']['title'],
                        'http://www.myarredo.' . $order->city->country->alias . Product::getUrl($item->product['alias']),
                        ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                    ); ?>

                    <br>
                    <span style="color:#9f8b80; font-size: 14px;"><?= $item->product['factory']['title']; ?></span>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

</div>
