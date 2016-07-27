<?php

//TODO 1: Разобраться с почтовыми сообщениями.
//TODO 2: Переписать на Массивы
//TODO 3: Ссылка должна формироваться в соотвествуюем модуле, если это глобальная ссылка
//TODO 4: Почему Сброс пароля размещен в профайле, если профайл за это не отвечает. Вынести в отдельный контроллер User/Password/Reset

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/user/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
