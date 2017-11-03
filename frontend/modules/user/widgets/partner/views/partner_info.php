<?php

use yii\helpers\Html;
?>
<meta itemprop="name" content="<?= Html::encode($partner['profile']['name_company']) ?>"/>

<div class="cons">Получить консультацию в <?= $city['lang']['title_where'] ?></div>
<div class="tel" itemprop="telephone"><i class="fa fa-phone" aria-hidden="true"></i><?= $partner['profile']['phone'] ?></div>
<div class="stud" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <meta itemprop="addressLocality" content="<?= $city['country']['lang']['title'] ?> <?= $city['lang']['title'] ?>"/>
    <meta itemprop="streetAddress" content="<?= $partner['profile']['address'] ?>"/>
    <?= $partner['profile']['name_company'] ?></br><?= $partner['profile']['address'] ?>
</div>