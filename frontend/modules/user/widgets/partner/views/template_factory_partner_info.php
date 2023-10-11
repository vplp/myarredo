<?php

use yii\helpers\Html;

?>

<div class="get-consl">
    <?php if(DOMAIN_TYPE != 'com') { ?>
        <p><?= Yii::t('app', 'Получить консультацию в') ?> <?= $city['lang']['title_where'] ?></p>
    <?php } ?>
    <p><?= Yii::$app->partner->getPartnerPhone() ?></p>
    <p><?= isset($partner['profile']['lang']) ? $partner['profile']->getNameCompany() : '' ?></p>
    <p><?= isset($partner['profile']['lang']) ? $partner['profile']['lang']['address'] : '' ?></p>
</div>
