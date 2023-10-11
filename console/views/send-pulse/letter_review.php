<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;
use frontend\modules\shop\models\{
    Order, OrderItem
};

/* @var $this yii\web\View */
/* @var $item OrderItem */
/* @var $order Order */

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

$hash = md5($order->customer->id)

?>

<div style="width:540px; font: 18px Arial,sans-serif;">
    <div style="text-align:center;">
        <p style="font-weight:bold;">
            <?=  Yii::t('app', 'Добрый день') . ', ' . $order->customer->full_name?>.
        </p>

        <p><?=  Yii::t('app', 'Вы оставляли заявку') . ' №' . $order->id . ' ' . date('Y-m-d H:i', $order->created_at) . ' ' . Yii::t('app', 'на сайте') . ' ' . 'MYARREDO.' . $domain ?></p>
    
        <div style="text-align:left;">
            <p><?= Yii::t('app', 'Нам очень важно ваше мнение о салонах, которые с вами связались, даже если покупка не состоялась, или у вас остался негативный осадок от взаимодействия. Мы обработаем ваш отклик и разместим его на сайте.') ?></p>

            <p><?= Yii::t('app', 'Ваша обратная связь поможет другим покупателям в выборе, а салонам позволит стать лучше!') ?></p>
            
            <p><?= Yii::t('app', 'Будем благодарны за прохождение опроса, он займет всего 3 минуты вашего времени.') ?></p>
        </div>

        <a href="https://www.myarredo.<?= $domain ?>/forms/feedback-after-order/<?=$order->id?>/?h=<?=$hash?>"
           style="text-decoration: none; color:#fff;">
            <div style="background-color:#00b05a; width: 80%; font-size: 18px; padding:20px; color: #fff; margin: 35px auto 20px; text-align: center;">
                <span style="display: block;"><?= Yii::t('app', 'Пройти опрос') ?></span>
            </div>
        </a>

        <p><?= Yii::t('app', 'С наилучшими пожеланиями') ?></p>
        <p><?= Yii::t('app', 'Команда')?> MY ARREDO FAMILY</p>
    </div>
</div>
