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

if (in_array($order->lang, ['ru-RU'])) {
    $domain = 'ru';
} else if (in_array($order->lang, ['it-IT'])) {
    $domain = 'com/it';
} else if (in_array($order->lang, ['en-EN'])) {
    $domain = 'uk';
} else if (in_array($order->lang, ['de-DE'])) {
    $domain = 'de';
} else if (in_array($order->lang, ['uk-UA'])) {
    $domain = 'ua';
} else if (in_array($order->lang, ['fr-FR'])) {
    $domain = 'fr';
}

?>

<div style="width:540px; font: 18px Arial,sans-serif;">
    <div style="background:#c4c0b8 url(https://www.myarredo.ru/uploads/mailer/logo_note.png) center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 18px Arial,sans-serif;">
            <?= Yii::t('app', 'Мы помогаем продавать мебель') ?>
        </span>
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

            echo Html::tag('span', $item->product['factory']['title']) . Html::tag('br');

            echo Html::a(
                $item->product['lang']['title'],
                'https://www.myarredo.' . $domain . '/product/' . $item->product['alias_it'] . '/',
                ['style' => 'font-weight:bold; display: block; color: #000; text-transform: uppercase; text-decoration: underline;']
            );
            ?>
        </p>
        <p style="font-weight:bold;">
            Riceviamo richieste siamo pronti a trasmetterla a voi GRATUITAMENTE.<br>
            <br>
            Se avete un reparto vendita al dettaglio in fabbrica, potete gestire voi stessi le richieste che vi inviamo
            e trasformarle in un ordine.<br>
            <br>
            In caso contrario, potete inviare hai vs. rivenditori - punti vendita al portale myarredo.com in modo che
            rispondano a queste richieste e continuino a lavorare con il cliente, per sviluppare l'ordine.<br>
            <br>
            Se il cliente non ordina per qualche motivo, il nostro servizio è GRATUITO.<br>
            <br>
            Se l'ordine è stato completato, dopo la sua chiusura, il venditore deve inserire l'importo della fattura
            netta della fabbrica nel suo account personale sul sito Web e gli emetteremo una fattura per un importo del
            10% della fattura, che dovrà essere pagate per i nostri servizi di ricerca dei clienti.<br>
            Attiriamo la vostra attenzione sul fatto che ogni cliente dal portale sarà monitorato per la soddisfazione
            del lavoro della nostra rete.<br>
            <br>
            Il portale ha già collegato 153 saloni di mobili in 4 paesi se state già ricevendo ordini da loro tramite
            noi, potete familiarizzare con le applicazioni e le statistiche sulla vs. fabbrica nel vs. account personale
            dopo la registrazione.<br>
            <br>
            Ora stiamo espandendo la nostra rete in Europa e in America.<br>
            <br>
            Potete aggiungere i vs. rivenditori in Europa e in America per ricevere ordini già elaborati dalla nostra
            risorsa.<br>
            Per tutte le ulteriori informazioni siamo sempre a vs. disposizione.<br>
            <br>
            In attesa porgiamo distinti saluti.<br>
            <br>
            my arredo
        </p>
        <p style="font-weight:bold;">
            <a href="https://www.myarredo.<?= $domain ?>/factory/registration/">registrazione per la fabbrica</a><br>
            <a href="https://www.myarredo.<?= $domain ?>/partner/registration/">registrazione per salone</a><br>
        </p>
    </div>
</div>
