<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;
use frontend\modules\shop\models\{
    Order, OrderItem, OrderItemPrice
};

/* @var $this yii\web\View */

/* @var $orderItem OrderItem */
/* @var $modelOrder Order */
/* @var $orderItemPrice OrderItemPrice */

// $domainAlias
$domainAlias = 'alias';
$lang = substr($modelOrder->lang, 0, 2);
if (!in_array($lang, ['ru', 'uk'])) {
    $domainAlias = 'alias_' . $lang;
}


?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url(https://www.myarredo.ru/uploads/mailer/logo_note.png) center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 18px Arial,sans-serif;">
            <?= Yii::t('app', 'Мы помогаем продавать мебель') ?>
        </span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p>
            <?= Yii::t('app', 'Отправляем Вам цены на запрошенные товары') ?>:
        </p>
    </div>

    <?php if ($modelOrder->items) { ?>
        <div style="background-color:#fff; padding:20px; clear: both;">

            <?php foreach ($modelOrder->items as $orderItem) { ?>
                <div style="clear: both; height: 100px;">
                    <div style="float: left;">
                        <?= Html::img(
                            Product::getImageThumb($orderItem->product['image_link']),
                            ['style' => 'width: 140px; max-height: 100px;']
                        ); ?>
                    </div>
                    <div style="float: left; margin: 10px 30px;">
                        <span style="color:#9f8b80; font-size: 14px;"><?= $orderItem->product['factory']['title']; ?></span>
                        <br>
                        <?= Html::a(
                            $orderItem->product['lang']['title'],
                            Product::getUrl($orderItem->product[$domainAlias]),
                            ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                        ); ?>
                    </div>
                </div>

                <?php foreach ($orderItem->orderItemPrices as $orderItemPrice) { ?>
                    <div style="clear: both; border-bottom: 1px solid #000;">
                        <div style="margin: 10px 0;">
                            <?php if ($orderItemPrice->out_of_production == '1') {
                                echo Yii::t('app', 'Снят с производства');
                            } else {
                                echo $orderItemPrice->price . ' ' . $orderItemPrice->currency;
                            } ?>
                        </div>
                        <div style="margin: 10px 0;">
                            <strong style="color: #591612;"><?= $orderItemPrice->user->profile->getNameCompany() ?></strong>
                            <?= $orderItemPrice->user->profile->partner_in_city ? Yii::t('app', 'Главный партнер') : ''; ?>
                            <br>
                            <?= $orderItemPrice->user->profile->city ? $orderItemPrice->user->profile->city->getTitle() : null; ?>
                            ,
                            <?= $orderItemPrice->user->profile->lang->address ?? ''; ?><br>
                            <?= $orderItemPrice->user->profile->phone; ?><br>
                            <i>
                                <?= Yii::t('app', 'Комментарий к ответу') ?>:<br>
                                <?= nl2br($orderItemPrice->orderAnswer->answer) ?>
                            </i>
                        </div>
                    </div>
                <?php } ?>

            <?php } ?>
        </div>
    <?php } ?>

    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p style="color: #591612;">
            <?= Yii::t('app', 'Обращяем Ваше внимание') ?>:
        </p>
        <p>
            <?= Yii::t('app', 'Цены партнеров отличаться, т.к. каждый из них имеет разные условия у фабрик на поставку товаров.') ?>
        </p>
    </div>
    <div style="background-color:#fff; text-align: center; padding: 10px 0 40px 10px;">
        <p style="color: #591612;">
            <a href="www.myarredo.ru" style="color: #591612;">www.myarredo.ru</a>
        </p>
    </div>
</div>
