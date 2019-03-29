<?php

use yii\helpers\Html;

?>

<div class="new-description">
    <div class="data-news"><?= $article->getPublishedTime() ?></div>
    <div class="title-news"><?= $article['lang']['title'] ?></div>
    <div class="short-new"><?= $article['lang']['full_description'] ?></div>
    <?= Html::a(Yii::t('front', 'Read more'), $article->getUrl(), ['class' => 'more-page']) ?>
</div>
<div class="img-for-new">
    <?= Html::img($article->getArticleImage()) ?>
</div>

