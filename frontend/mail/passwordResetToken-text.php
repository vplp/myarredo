<?php

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/password/reset', 'token' => $user->password_reset_token]);
?>
Здравствуйте <?= $user->username ?>,

Следуйте приведенной ниже ссылке, чтобы сбросить пароль:

<?= $resetLink ?>
