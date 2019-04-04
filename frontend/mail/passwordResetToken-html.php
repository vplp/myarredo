<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/password/reset', 'token' => $user->password_reset_token]);
?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('https://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">Мы помогаем купить итальянскую мебель по лучшим ценам.</span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>

        <p>Следуйте приведенной ниже ссылке, чтобы сбросить пароль:</p>

        <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    </div>
</div>


