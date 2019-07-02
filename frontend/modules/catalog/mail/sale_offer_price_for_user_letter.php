<?php

use yii\helpers\Html;
//
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
                <?= Yii::t('app', 'Мы помогаем купить итальянскую мебель по лучшим ценам.') ?>
            </span>
        </div>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p>Здравствуйте, <?= $model->user_name ?>!</p>
        <p>Вы предложили салону свою цену <?= $model->offer_price ?> на данный товар:</p>
        <div style="clear: both;">
            <div style="float: left;">
                <?= Html::img(
                    'https://www.myarredo.' . $modelSale->city->country->alias . Sale::getImageThumb($modelSale['image_link']),
                    ['class' => 'width: 140px; max-height: 100px;']
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
        <div style="background: #CF0002; color: #FFF; font-size: 13px; padding: 0 7px!important; align-items: center;text-transform: uppercase;">
            <?= Yii::t('app', 'Цена') ?>:
            <span style="font-size: 23px; font-weight: 700;"><?= $modelSale->price_new . ' ' . $modelSale->currency ?></span>
        </div>
        <p>Ожидайте с вами свяжется менеджер салона.</p>
    </div>
</div>
