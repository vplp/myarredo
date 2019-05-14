<?php

use yii\helpers\Html;

?>

<div class="get-consl">
    <p><?= Yii::t('app', 'Получить консультацию в') ?> <?= $city['lang']['title_where'] ?></p>
    <p><?= Yii::$app->partner->getPartnerPhone() ?></p>
    <p><?= $partner['profile']['lang']['name_company'] ?></p>
    <p><?= $partner['profile']['lang']['address'] ?></p>
</div>