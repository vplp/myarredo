<?php

use yii\helpers\Html;

?>

<div class="newsbox-item">
    <div><?= Html::encode($article['lang']['title']) ?></div>
    <div><?= $article['lang']['description'] ?></div>
    <!-- <div><?= Html::a(Yii::t('app', 'Подробнее'), $article->getUrl(), ['class' => '']) ?></div>   -->
</div>