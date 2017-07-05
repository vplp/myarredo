<?php

//TODO 1: Разобраться с почтовыми сообщениями.

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */

$resetLink = Yii::$app->getUrlManager()->createAbsoluteUrl(['/user/password/reset', 'token' => $user['password_reset_token']]);
?>
Hello <?= $user['username'] ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
