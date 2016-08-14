<?php

//TODO 1: Разобраться с почтовыми сообщениями.
//TODO 3: Ссылка должна формироваться в соотвествуюем модуле, если это глобальная ссылка
//TODO 4: Почему Сброс пароля размещен в профайле, если профайл за это не отвечает. Вынести в отдельный контроллер User/Password/Reset

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */

$resetLink = Yii::$app->getUrlManager()->createAbsoluteUrl(['/user/user/reset-password', 'token' => $user['password_reset_token']]);
?>
Hello <?= $user['username'] ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
