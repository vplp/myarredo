<?php

/* @var $this yii\web\View */

/* @var $title string */
/* @var $message string */
/* @var $url string */

use yii\helpers\Html; ?>

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
        <div><?= $title ?></div>
        <div><?= $message ?></div>
        <div><?= $url ?></div>
    </div>
</div>


