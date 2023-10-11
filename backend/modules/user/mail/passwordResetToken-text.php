<?php

$resetLink = Yii::$app->getUrlManager()->createAbsoluteUrl(['/user/password/reset', 'token' => $user['password_reset_token']]);
?>
Hello <?= $user['username'] ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
