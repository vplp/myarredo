<?php

/* @var $this yii\web\View */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('https://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">
            <?= Yii::t('app', 'Мы помогаем купить итальянскую мебель по лучшим ценам.') ?>
        </span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <div><?= $message ?></div>
        <div><?= $title ?></div>
        <div><?= $url ?></div>
    </div>
</div>


