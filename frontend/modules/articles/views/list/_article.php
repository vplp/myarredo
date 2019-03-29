<?php

use yii\helpers\Html;

?>

<div class="news">
    <div class="img-for-new"><?= Html::img($article->getArticleImage()) ?></div>
    <div class="all-news-descript">
        <div class="data-news"><?= $article->getPublishedTime() ?></div>
        <div class="title-for-all-news"><?= $article['lang']['title'] ?></div>
        <div class="short-new"><?= $article['lang']['description'] ?></div>
        <?= Html::a(Yii::t('front', 'Read more'), $article->getUrl(), ['class' => 'more-page']) ?>
    </div>
</div>