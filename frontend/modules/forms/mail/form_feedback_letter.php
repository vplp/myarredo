<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\forms\models\FormsFeedback */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('https://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">Мы помогаем купить итальянскую мебель по лучшим ценам.</span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p>Поступил новый вопрос на связаться с оператором сайта:</p>
        <p><?= $model->getAttributeLabel('email') ?>: <?= $model->email ?></p>
        <p><?= $model->getAttributeLabel('user_name') ?>: <?= $model->name ?></p>
        <p><?= $model->getAttributeLabel('phone') ?>: <?= $model->phone ?></p>
        <p><?= $model->getAttributeLabel('comment') ?>: <?= $model->comment ?></p>
    </div>
</div>