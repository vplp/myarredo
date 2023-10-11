<?php

use yii\helpers\Html;
//
use frontend\modules\forms\models\FormsFeedback;

/* @var $this yii\web\View */
/* @var $model FormsFeedback */

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
        <p>Поступил новый вопрос:</p>

        <?php if ($model->partner_id) { ?>
            <p><?= $model->getAttributeLabel('partner_id') ?>: <?= $model->partner->profile->getNameCompany() ?></p>
        <?php } ?>

        <?php if ($model->city_id) { ?>
            <p><?= $model->getAttributeLabel('city_id') ?>: <?= $model->city->getTitle() ?></p>
        <?php } ?>

        <?php if ($model->country) { ?>
            <p><?= $model->getAttributeLabel('country') ?>: <?= $model->country ?></p>
        <?php } ?>

        <?php if ($model->subject) { ?>
            <p><?= $model->getAttributeLabel('subject') ?>: <?= $model->subject ?></p>
        <?php } ?>

        <p><?= $model->getAttributeLabel('email') ?>: <?= $model->email ?></p>
        <p><?= $model->getAttributeLabel('name') ?>: <?= $model->name ?></p>
        <p><?= $model->getAttributeLabel('phone') ?>: <?= $model->phone ?></p>
        <p><?= $model->getAttributeLabel('comment') ?>: <?= $model->comment ?></p>
    </div>
</div>
