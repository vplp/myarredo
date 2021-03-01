<?php

use yii\helpers\Html;
use frontend\modules\news\models\Article;

/** @var $article Article */

?>

<div class="article-item">
    <div class="article-item-box">
        <a class="article-item-imglink" href="<?= $article->getUrl() ?>">
            <div class="article-item-img"><?= Html::img(Article::getImageThumb($article['image_link'])) ?></div>
        </a>
        <div class="article-item-descr">
            <div class="article-item-title"><?= $article['lang']['title'] ?></div>
            <div class="article-item-shortdescr"><?= $article['lang']['description'] ?></div>
            <div class="panel-article-item">
                <?= Html::a(
                    Yii::t('app', 'Подробнее'),
                    $article->getUrl(),
                    ['class' => 'btn-aricle-more']
                ) ?>
                <div class="article-item-data">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <?= $article->getPublishedTime() ?>
                </div>
            </div>
        </div>
    </div>
</div>
