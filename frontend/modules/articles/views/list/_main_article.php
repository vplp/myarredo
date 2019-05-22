<?php

use yii\helpers\Html;
//
use frontend\modules\articles\models\Article;

/** @var $article Article */

?>

<div class="new-description">
    <div class="data-news"><?= $article->getPublishedTime() ?></div>
    <div class="title-news"><?= $article['lang']['title'] ?></div>
    <div class="short-new"><?= $article['lang']['description'] ?></div>
    <?= Html::a(
        Yii::t('app', 'Подробнее'),
        $article->getUrl(),
        ['class' => 'more-page']
    ) ?>
</div>
<div class="img-for-new">
    <?= Html::img($article->getArticleImage()) ?>
</div>

