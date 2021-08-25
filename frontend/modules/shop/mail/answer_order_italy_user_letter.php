<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\ItalianProduct;
use frontend\modules\shop\models\{
    Order, OrderItem
};

/* @var $this yii\web\View */

/* @var $item Product */
/* @var $product OrderItem */
/* @var $modelOrder Order */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8; padding:15px 0 0; color:#fff;">
        <p style="text-transform: uppercase; margin:0; padding-left: 20px;">
            <?= $modelOrder->orderAnswer->user->profile->getNameCompany(); ?>
            <span style="display: block; font-style: italic;text-transform: none;">
                <?= Yii::t('app', 'Студия итальянской мебели, участник сети') ?>
            </span>
        </p>
    </div>
    <div style="background:#c4c0b8; padding:15px 0; text-align: center;">
        <img src="https://www.myarredo.ru/uploads/mailer/logo_note.png" alt="logo">
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 30px;">
        <p style="font-size: 18px;">
            <?= Yii::t('app', 'Здравствуйте, {full_name}', ['full_name' => $modelOrder->customer['full_name']]) ?>
        </p>
        <p style="font-size: 16px; color: #591612;">
            <?= Yii::t('app', 'Согласно вашему запросу № {order_id} в {time} года, отправляем цены на интересующие Вас товары. Спасибо за обращение!', ['order_id' => $modelOrder['id'], 'time' => $modelOrder->getCreatedTime()]) ?>
        </p>
    </div>

    <?php if ($modelOrder->items) { ?>
        <div style="background-color:#fff; padding:20px; clear: both;">
            <p style="color: #591612; font-size: 16px;"><?= Yii::t('app', 'Цены на запрошенные товары') ?></p>
            <?php foreach ($modelOrder->items as $item) { ?>
                <div style="clear: both; height: 100px;">
                    <div style="float: left;">
                        <?= Html::img(
                            Product::getImageThumb($item->product['image_link']),
                            ['style' => 'width: 140px; max-height: 100px;']
                        ); ?>
                    </div>
                    <div style="float: left; margin: 10px 30px;">
                        <span style="color:#9f8b80; font-size: 14px;"><?= $item->product['factory']['title']; ?></span>
                        <br>
                        <?= Html::a(
                            $item->product['lang']['title'],
                            ItalianProduct::getUrl($item->product[Yii::$app->languages->getDomainAlias()]),
                            ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                        ); ?>
                    </div>
                    <div style="padding-top: 10px; color:#8e3628"><?= $item->orderItemPrice->price . ' ' . $item->orderItemPrice->currency; ?></div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if ($modelOrder->orderAnswer->answer) { ?>
        <div style="background-color:#fff; padding:20px;">
            <p style="color: #591612; font-size: 16px;">
                <?= Yii::t('app', 'Примечание') ?>
            </p>
            <p style="background: url('https://www.myarredo.ru/uploads/mailer/cloud.png') 20px 5px no-repeat; width:410px; padding-left: 80px;">
                <?= nl2br($modelOrder->orderAnswer->answer) ?>
            </p>
        </div>
    <?php } ?>

    <div style="background-color:#c4c0b8; padding:25px 60px 20px;">
        <?php if ($modelOrder->orderAnswer->user->group->role == 'partner') { ?>
            <p style="color: #591612; margin-bottom: 1px;">
                <?= $modelOrder->orderAnswer->user->profile->getNameCompany(); ?><br>
                <?= $modelOrder->orderAnswer->user->profile->city ? $modelOrder->orderAnswer->user->profile->city->getTitle() : null; ?><br>
                <?= $modelOrder->orderAnswer->user->profile->lang->address ?? ''; ?>
            </p>
        <?php } ?>
        <span style="display: block; color: #591612; margin-bottom: 5px;">
            <?= $modelOrder->orderAnswer->user->email; ?>
        </span>
        <span style="text-align: left; color: #0077ca; border-bottom: 1px dotted #0077ca;">
            <?= $modelOrder->orderAnswer->user->profile->phone; ?>
        </span>
    </div>

</div>
