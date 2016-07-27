<?php

use yii\helpers\Html;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
?>

<div class="news clearfix">
    <?php if ($article->getArticleImage()): ?>
        <img src="<?= $article->getArticleImage() ?>">
    <?php endif; ?>
    <div class="date"><?= $article->getPublishedTime() ?></div>
    <div class="title"><a href="<?= $article->getUrl() ?>"><?= Html::encode($article['lang']['title']) ?></a></div>
    <div class="desc"><?= $article['lang']['description'] ?></div>
</div>