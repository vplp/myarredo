<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Sale;

/* @var $this yii\web\View */
/* @var $modelSale \frontend\modules\catalog\models\Sale */
/* @var $model \frontend\modules\catalog\models\SaleRequest */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('http://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">Мы помогаем купить итальянскую мебель по лучшим ценам.</span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p>Здравствуйте, <?= $modelSale->user['profile']['first_name'] ?>!</p>
        <p>Поступил новый вопрос на товар:</p>
        <div style="clear: both; height: 100px;">
            <div style="float: left;">
                <?= Html::img(
                    'http://www.myarredo.' . $modelSale->city->country->alias . Sale::getImageThumb($modelSale['image_link']),
                    ['class' => 'width: 140px; max-height: 100px;']
                ) ?>
            </div>
            <div style="float: left; margin: 10px 30px;">
                <?= Html::a(
                    $modelSale->getTitle(),
                    $modelSale->getUrl(),
                    ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                ) ?>
                <br>
                <span style="color:#9f8b80; font-size: 14px;"><?= ($modelSale['factory']) ? $modelSale['factory']['title'] : $modelSale['factory_name'] ?></span>
            </div>
        </div>
        <p><?= $model->getAttributeLabel('email') ?>: <?= $model->email ?></p>
        <p><?= $model->getAttributeLabel('user_name') ?>
            : <?= $model->user_name ?></p>
        <p><?= $model->getAttributeLabel('phone') ?>: <?= $model->phone ?></p>
        <p><?= $model->getAttributeLabel('question') ?>
            : <?= $model->question ?></p>
    </div>
</div>
