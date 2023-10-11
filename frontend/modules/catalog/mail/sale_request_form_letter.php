<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Sale, SaleRequest
};

/* @var $this yii\web\View */
/* @var $modelSale Sale */
/* @var $model SaleRequest */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background-color: #c4c0b8; padding:15px 0; text-align:center;">
        <div>
            <?= Html::img(
                'https://www.myarredo.ru/uploads/mailer/logo_note.png'
            ) ?>
        </div>
        <div>
            <span style="color: #fff; font:bold 16px Arial,sans-serif;">
                <?= Yii::t('app', 'Мы помогаем купить мебель по лучшим ценам.') ?>
            </span>
        </div>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p>Здравствуйте, <?= $modelSale->user['profile']['first_name'] ?>!</p>
        <p>Поступил новый вопрос на товар:</p>
        <div style="clear: both; height: 100px;">
            <div style="float: left;">
                <?= Html::img(
                    Sale::getImageThumb($modelSale['image_link']),
                    ['style' => 'width: 140px; max-height: 100px;']
                ) ?>
            </div>
            <div style="float: left; margin: 10px 30px;">
                <?= Html::a(
                    $modelSale->getTitle(),
                    Sale::getUrl($modelSale['alias']),
                    ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                ) ?>
                <br>
                <span style="color:#9f8b80; font-size: 14px;"><?= ($modelSale['factory']) ? $modelSale['factory']['title'] : $modelSale['factory_name'] ?></span>
            </div>
        </div>
        <p><?= $model->getAttributeLabel('email') ?>: <?= $model->email ?></p>
        <p><?= $model->getAttributeLabel('user_name') ?>: <?= $model->user_name ?></p>
        <p><?= $model->getAttributeLabel('phone') ?>: <?= $model->phone ?></p>
        <p><?= $model->getAttributeLabel('question') ?>: <?= $model->question ?></p>
    </div>
</div>
