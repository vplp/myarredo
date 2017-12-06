<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\OrderItem */
/* @var $modelOrder \frontend\modules\shop\models\Order */

?>

<div style="width:540px; height: 700px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('http://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">Мы помогаем купить итальянскую мебель по лучшим ценам.</span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p style="font-size: 16px;">Здравствуйте, <?= $modelOrder->customer['full_name'] ?></p>
        <p style="font-size: 13px; color: #591612;">Согласно вашему запросу № <span
                    style="font-weight: bold; color: #000;">№<?= $modelOrder['id'] ?></span>
            от <?= $modelOrder->getCreatedTime(); ?> года,
            отправляем цены на интересующие Ваc товары. Спасибо за обращение!</p>
    </div>

    <div style="background-color:#fff; padding:20px; clear: both; display: block;">
        <p style="color: #591612; font-size: 15px;">Цены на запрошенные товары</p>

        <?php foreach ($modelOrder->items as $item): ?>
            <div style="clear: both; height: 100px;">
                <div style="float: left;">

                    <?= Html::img(
                        'http://www.myarredo.ru' . Product::getImageThumb($item->product['image_link']),
                        ['class' => 'width: 140px; max-height: 100px;']
                    ); ?>

                </div>
                <div style="float: left; margin: 10px 30px;">

                    <?= Html::a(
                        $item->product['lang']['title'],
                        Product::getUrl($item->product['alias']),
                        ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                    ); ?>

                    <br>
                    <span style="color:#9f8b80; font-size: 14px;"><?= $item->product['factory']['lang']['title']; ?></span>
                    <br>
                    <?= $item->orderItemPrice->price; ?>

                </div>
            </div>
        <?php endforeach; ?>

        <?= $modelOrder->orderAnswer->answer; ?>

    </div>

    <div style="background-color:#c4c0b8; padding:25px 60px 20px;">
        <p style="color: #591612; margin-bottom: 1px;">
            <?= $modelOrder->orderAnswer->user->profile->name_company; ?><br>
            <?= $modelOrder->orderAnswer->user->profile->city->lang->title; ?><br>
            <?= $modelOrder->orderAnswer->user->profile->address; ?>
        </p>
        <span style="display: block; color: #591612; margin-bottom: 5px;"><?= $modelOrder->orderAnswer->user->email; ?></span>
        <span style="text-align: left; color: #0077ca; border-bottom: 1px dotted #0077ca;"><?= $modelOrder->orderAnswer->user->profile->phone; ?></span>
    </div>

</div>