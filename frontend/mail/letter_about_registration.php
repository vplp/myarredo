<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $user User */
/* @var $password User['password'] */

$search = [
    '#first_name#',
    '#email#',
    '#password#',
    '#token#'
];

$token_url = Yii::$app->getRequest()->hostInfo .
    Url::toRoute([
        '/user/register/confirmation',
        'token' => $user['auth_key']
    ]);

$replace = [
    Html::encode($user['profile']['first_name']),
    $user['email'],
    $password,
    Html::a($token_url, $token_url)
];

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('https://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">Мы помогаем купить итальянскую мебель по лучшим ценам.</span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">
        <?= str_replace($search, $replace, $text); ?>
    </div>
</div>
