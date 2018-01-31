<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\OrderItem */
/* @var $modelOrder \frontend\modules\shop\models\Order */

?>

<div style="width:540px; height: 700px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8; padding:15px 0 0; color:#fff;">
        <p style="text-transform: uppercase; margin:0; padding-left: 20px;">
            <?= $modelOrder->orderAnswer->user->profile->name_company; ?>
            <span style="display: block; font-style: italic;text-transform: none;">Студия итальянской мебели</span></p>
        <span style="padding-left: 20px; font-style: italic;">участник сети</span>
    </div>
    <div style="background:#c4c0b8; padding:15px 0; text-align: center;">
        <img src="http://www.myarredo.ru/uploads/mailer/logo_note.png" alt="logo">
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 30px;">
        <p style="font-size: 18px;">Здравствуйте, <?= $modelOrder->customer['full_name'] ?></p>
        <p style="font-size: 16px; color: #591612;">Согласно вашему <span style="font-weight: bold; color: #000;">запросу №<?= $modelOrder['id'] ?></span>
            от <?= $modelOrder->getCreatedTime(); ?> года, отправляем цены на интересующие Вас товары. Спасибо за обращение!</p>
    </div>

    <div style="background-color:#fff; padding:20px; clear: both;">
        <p style="color: #591612; font-size: 16px;">Цены на запрошенные товары</p>

        <?php foreach ($modelOrder->items as $item): ?>
            <div style="clear: both; height: 100px;">
                <div style="float: left;">
                    <?= Html::a(
                        $item->product['lang']['title'],
                        Product::getUrl($item->product['alias']),
                        ['style' => 'width: 140px; max-height: 100px;']
                    ); ?>
                </div>
                <div style="float: left; margin: 10px 30px;">
                    <?= Html::a(
                        $item->product['lang']['title'],
                        Product::getUrl($item->product['alias']),
                        ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                    ); ?>
                    <br>
                    <span style="color:#9f8b80; font-size: 14px;"><?= $item->product['factory']['title']; ?></span>
                </div>
                <div style="padding-top: 10px; color:#8e3628"><?= $item->orderItemPrice->price; ?> &euro;</div>
            </div>

        <?php endforeach; ?>

    </div>

    <?php if ($modelOrder->orderAnswer->answer): ?>
        <div style="background-color:#fff; padding:20px;">
            <p style="color: #591612; font-size: 16px;">Примечание</p>
            <p style="background: url('http://www.myarredo.ru/uploads/mailer/cloud.png') 20px 5px no-repeat; width:410px; padding-left: 80px;">
                <?= nl2br($modelOrder->orderAnswer->answer) ?>
            </p>
        </div>
    <?php endif; ?>

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
