<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \thread\modules\user\models\User */
/* @var $model \frontend\modules\user\models\form\RegisterForm */
/* @var $modelUser \frontend\modules\user\models\User */

?>

<div>Зарегистрирована новая фабрика</div>

<div><?= $model->getAttributeLabel('name_company') ?>: <?= $model->name_company ?></div>
<div><?= $model->getAttributeLabel('phone') ?>: <?= $model->phone ?></div>
<div><?= $model->getAttributeLabel('email') ?>: <?= $model->email ?></div>
<div><?= $model->getAttributeLabel('first_name') ?>: <?= $model->first_name ?></div>
<div><?= $model->getAttributeLabel('last_name') ?>: <?= $model->last_name ?></div>

