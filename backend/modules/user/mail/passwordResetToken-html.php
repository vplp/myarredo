<?php

//TODO 1: Разобраться с почтовыми сообщениями.

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */

$resetLink = Yii::$app->getUrlManager()->createAbsoluteUrl(['/user/password/reset', 'token' => $user['password_reset_token']]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user[username]) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
