<?php

use yii\helpers\Html;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
?>

<!--<div class="caption1">-->
    <?php if ($article->getArticleImage()): ?>
        <img class="cover"
             src="<?= $article->getArticleImage() ?>"
             alt="the best"
             srcset="<?= $article->getArticleImage() ?> 620w,
                        <?= $article->getArticleImage() ?> 540w,
                        <?= $article->getArticleImage() ?> 320w">
    <?php endif; ?>
    <div class="caption">
        <div class="date"><?= $article->getPublishedTime() ?></div>
        <div class="title"><a href="<?= $article->getUrl() ?>"><?= Html::encode($article['lang']['title']) ?></a></div>
        <div class="desc"><?= $article['lang']['description'] ?></div>
    </div>
