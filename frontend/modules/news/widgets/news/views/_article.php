<?php

use yii\helpers\Html;

?>

<div>
    <div><?= Html::encode($article['lang']['title']) ?></div>
    <div><?= $article['lang']['description'] ?></div>
    <div><?= Html::a(Yii::t('app', 'Подробнее'), $article->getUrl(), ['class' => '']) ?>
</div>