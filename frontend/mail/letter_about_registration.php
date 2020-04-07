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
    Html::a(Yii::t('app', 'Подтвердить'), $token_url)
];

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
        <?= str_replace($search, $replace, $text); ?>
    </div>
</div>
