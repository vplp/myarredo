<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\shop\models\{
    Order, OrderItem
};

/* @var $this yii\web\View */
/* @var $item OrderItem */
/* @var $order Order */

if (in_array($order->lang, ['ru-RU'])) {
    $domain = 'ru';
} else if (in_array($order->lang, ['en-EN', 'it-IT'])) {
    $domain = 'com/it';
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
            <?= Html::a(
                Yii::t('app', 'Новая заявка'),
                'https://www.myarredo.' . $domain . '/partner/orders/'
            ) . ' ' .
            Yii::t('app', 'Распродажа с Италии на сайте') . ' ' . 'MYARREDO.' . $domain ?>

            <?php if (in_array($order->lang, ['ru-RU']) && $order->city && $order->city->lang) { ?>
                <span style="display:block;">
                    <?= Yii::t('app', 'Клиент из г.') . $order->city->lang->title ?>
                </span>
            <?php } ?>
        </p>

        <p><?= Yii::t('app', 'Клиента интересует следующая мебель') ?>:</p>

        <?php
        foreach ($order->items as $item) {
            echo Html::beginTag('p');

            if (ItalianProduct::isImage($item->product['image_link'])) {
                echo Html::img(
                    ItalianProduct::getImageThumb($item->product['image_link']),
                    ['style' => 'width: 140px; max-height: 100px;']
                );
            }

            echo Html::a(
                $item->product['lang']['title'],
                'https://www.myarredo.' . $domain . '/sale-italy-product/' . $item->product['alias'] . '/',
                ['style' => 'font-weight:bold; display: block; color: #000; text-transform: uppercase; text-decoration: underline;']
            );

            echo Html::endTag('p');
        }

        // phone
        $phone = ($order->city && $order->city->country->alias == 'ua') ? '+39 (0422) 150-02-15' : '+7 968 353 36 36';
        ?>

        <div style="text-align: left; padding-left: 20px;">
            <?= Yii::$app->param->getByName('LETTER_NEW_ORDER_SALE_ITALY') ?>
        </div>

        <p><?= Yii::t('app', 'Удачи в продажах!') ?></p>

        <a href="https://www.myarredo.<?= $domain ?>/partner/orders-italy/"
           style="text-decoration: none; color:#fff;">
            <div style="background-color:#00b05a; width: 80%; font-size: 18px; padding:20px; color: #fff; margin: 35px auto 20px; text-align: center;">
                <span style="display: block;"><?= Yii::t('app', 'Получить клиента') ?></span>
            </div>
        </a>
    </div>
    <div style="background-color:#c4c0b8; padding:15px 60px;">
        <span style="display: block; color: #000; font-style: italic; padding-bottom: 10px;">
            <?= Yii::t('app', 'Телефон для связи с администрацией проекта') ?>
        </span>
        <span style="text-align: left; color: #0077ca; border-bottom: 1px dotted #0077ca;"><?= $phone ?></span>
    </div>
</div>
