<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;
use frontend\modules\shop\models\{
    Order, OrderItem
};

/* @var $this yii\web\View */
/* @var $item OrderItem */
/* @var $order Order */
/* @var $isUser boolean */

//if (in_array($order->lang, ['ru-RU'])) {
//    $domain = 'ru';
//} else if (in_array($order->lang, ['en-EN', 'it-IT'])) {
//    $domain = 'com/it';
//} else if (in_array($order->lang, ['de-DE'])) {
//    $domain = 'de';
//} else if (in_array($order->lang, ['uk-UA'])) {
//    $domain = 'ua';
//}

$domain = 'com/it';

?>

<div style="width:540px; font: 18px Arial,sans-serif;">
    <div style="background:#c4c0b8 url(https://www.myarredo.ru/uploads/mailer/logo_note.png) center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 18px Arial,sans-serif;">Aiutiamo a vendere mobili</span>
    </div>
    <div style="text-align:center;">
        <p style="font-weight:bold;">
            Buongiorno,
        </p>
        <p style="font-weight:bold;">
            Il cliente è interessato al seguente mobile:
        </p>
        <p style="font-weight:bold;">
            <?php
            if (Product::isImage($item->product['image_link'])) {
                echo Html::img(
                    Product::getImageThumb($item->product['image_link']),
                    ['class' => 'width: 140px; max-height: 100px;']
                );
            }

            echo Html::a(
                $item->product['lang']['title'],
                'https://www.myarredo.' . $domain . '/product/' . $item->product['alias_it'] . '/',
                ['style' => 'font-weight:bold; display: block; color: #000; text-transform: uppercase; text-decoration: underline;']
            );
            ?>
        </p>
        <p style="font-weight:bold;">
            Abbiamo ricevuto la richiesta da <?= $order->country->getTitle() ?>.<br>
            Per elaborare le richieste e trasformarli in un ordine potete collegare vostri<br>
            diller oppure saloni di vendita al portale myarredo.com, per rispondere a<br>
            queste richieste e lavorare ulteriormente con il cliente.<br>
            In questo momento e attiva la PROMOZIONE:<br>
            Registrazione e elaborazione delle richieste gratuita!!!
        </p>
        <p style="font-weight:bold;">
            <a href="https://www.myarredo.<?= $domain ?>/factory/registration/">Registrazione per la fabbrica</a><br>
            <a href="https://www.myarredo.<?= $domain ?>/partner/registration/">Registrazione per salone</a><br>
        </p>
    </div>
</div>
