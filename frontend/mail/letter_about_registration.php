<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \frontend\modules\user\models\User */

$search = ['#first_name#', '#email#', '#password#'];
$replace = [Html::encode($user['first_name']), $user['email'], $password];

echo str_replace($search, $replace, $text);