<?php

use yii\helpers\Html;

?>

<div class="article-item">
    <div class="article-item-box">
        <a class="article-item-imglink" href="<?= $article->getUrl() ?>">
            <div class="article-item-img"><?= Html::img($article->getArticleImage()) ?></div>
        </a>
        <div class="article-item-descr">           
            <div class="article-item-title"><?= $article['lang']['title'] ?></div>
            <div class="article-item-shortdescr"><?= $article['lang']['description'] ?></div>
            <div class="panel-article-item">
                <?= Html::a(Yii::t('front', 'Read more'), $article->getUrl(), ['class' => 'btn-aricle-more']) ?>
                <div class="article-item-data"> <i class="fa fa-calendar" aria-hidden="true"></i> <?= $article->getPublishedTime() ?></div>
            </div>
        </div>
    </div>
</div>