<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\ItalianProduct;

/** @var $this yii\web\View */
/** @var $model ItalianProduct */

$search = ['FULL_NAME'];

$replace = [
    $model->user->profile->getFullName()
];

$text = str_replace($search, $replace, $text);

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('https://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">
            <?= Yii::t('app', 'Мы помогаем купить итальянскую мебель по лучшим ценам.') ?>
        </span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <?= $text ?>
    </div>
    <div style="background-color:#fff; padding:20px; clear: both; display: block;">
        <div style="clear: both; height: 100px;">
            <div style="float: left;">
                <?= Html::img(
                    'https://www.myarredo.' . $model['alias'] . ItalianProduct::getImageThumb($model['image_link']),
                    ['class' => 'width: 140px; max-height: 100px;']
                ) ?>
            </div>
            <div style="float: left; margin: 10px 30px;">
                <?= Html::a(
                    $model['lang']['title'],
                    'https://www.myarredo.ru/italian-product/update/' . $model->id,
                    ['style' => 'font-weight:bold; color: #000; text-transform: uppercase; text-decoration: underline;']
                ) ?>
            </div>
        </div>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <?= Html::a(
            Yii::t('app', 'View'),
            'https://www.myarredo.ru/italian-product/update/' . $model->id,
            ['style' => '']
        ) ?>
    </div>
</div>
