<?php

use frontend\modules\articles\models\Article;
use frontend\modules\articles\widgets\articles\ArticlesList;
use frontend\themes\myarredo\assets\AppAsset;

/** @var $model Article */

$bundle = AppAsset::register($this);

$this->title = $model['lang']['title'];
?>

<div class="myarredo-blog-wrap">
    <div class="myarredo-blogbox">
        <div class="myarredo-blogartbox">

            <!-- Контент старт -->
            <div class="single-articlebox" itemscope itemtype="http://schema.org/Article">
                <h1 class="article-title"><?= $model['lang']['title'] ?></h1>
                <article class="article-textbox" itemprop="articleBody">
                    <?= $model['lang']['content'] ?>
                </article>
            </div>
            <!-- Контент конец -->

            <!-- Сайдбар старт -->
            <?= ArticlesList::widget(['view' => 'articles_assidebox', 'limit' => 2]) ?>
            <!-- Сайдбар конец -->

            <!-- Похожие статьи старт -->
            <?= ArticlesList::widget(['view' => 'articles_similarbox', 'limit' => 4]) ?>
            <!-- Похожие статьи конец -->

        </div>
    </div>
</div>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?= $model->getUrl(true) ?>"
    },
    "headline": "<?= $model['lang']['title'] ?>",
    "image": [
        "<?= Article::getImageThumb($model['image_link']) ?>"
    ],
    "datePublished": "<?= date('Y-m-d', $model->published_time) ?>",
    "dateModified": "<?= date('Y-m-d', $model->updated_at) ?>",
    "author": {
        "@type": "Person",
        "name": "MyArredo"
    },
    "publisher": {
        "@type": "Organization",
        "name": "MyArredoFamily",
        "logo": {
            "@type": "ImageObject",
            "url": "<?= 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE ?>/uploads/myarredo-ico.jpg"
        }
    }
}
</script>
