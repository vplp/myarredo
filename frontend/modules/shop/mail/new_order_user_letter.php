<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;
use frontend\modules\shop\models\{CartItem, Order};

/* @var $this yii\web\View */
/* @var $item Product */
/* @var $order Order */
/* @var $product CartItem */

$search = ['#full_name#', '#order_id#'];

$replace = [
    $order->customer['full_name'],
    $order['id']
];

$text = str_replace($search, $replace, $text);

if (in_array($order->lang, ['ru-RU'])) {
    $domain = 'ru';
} else if (in_array($order->lang, ['en-EN', 'it-IT'])) {
    $domain = 'com/it';
} else if (in_array($order->lang, ['de-DE'])) {
    $domain = 'de';
} else if (in_array($order->lang, ['uk-UA'])) {
    $domain = 'ua';
}

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background-color: #c4c0b8; padding:15px 0; text-align:center;">
        <div>
            <?= Html::img('https://www.myarredo.ru/uploads/mailer/logo_note.png') ?>
        </div>
        <div>
            <span style="color: #fff; font:bold 16px Arial,sans-serif;">
                <?= Yii::t('app', 'Мы помогаем купить мебель по лучшим ценам.') ?>
            </span>
        </div>
    </div>

    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;font-size: 14px;">

        <?= $text ?>

    </div>

    <?php if ($order->items) { ?>
        <div style="background-color:#fff; padding:20px; clear: both; display: block;">
            <p style="color: #591612; font-size: 15px;">
                <?= Yii::t('app', 'Запрошенные товары') ?>
            </p>

            <?php foreach ($order->items as $item) { ?>
                <div style="clear: both; height: 100px;">
                    <div style="float: left;">

                        <?= Html::img(
                            Product::getImageThumb($item->product['image_link']),
                            ['style' => 'width: 140px; max-height: 100px;']
                        ) ?>

                    </div>
                    <div style="float: left; margin: 10px 30px;">

                        <?= Html::a(
                            $item->product['lang']['title'],
                            'https://www.myarredo.' . $domain . '/product/' . $item->product['alias'] . '/',
                            ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                        ); ?>

                        <br>
                        <span style="color:#9f8b80; font-size: 14px;"><?= $item->product['factory']['title']; ?></span>
                    </div>
                </div>
            <?php } ?>

        </div>
    <?php } ?>

    <?php if ($order->image_link) { ?>
        <div style="clear: both; height: 100px;">
            <div style="float: left;">
                <?= Html::img('https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE . $order->getImageLink(), ['style' => 'width: 140px; max-height: 100px;']); ?>
            </div>
        </div>
    <?php } ?>

</div>
