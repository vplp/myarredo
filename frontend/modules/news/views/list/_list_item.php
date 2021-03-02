<?php

use yii\helpers\Html;
use frontend\modules\news\models\Article;

?>

<div class="news">
    <figure>
        <?php if (Article::isImage($article['image_link'])) { ?>
            <img src="<?= $article->getArticleImage() ?>"
                 alt="news"
                 srcset="<?= $article->getArticleImage() ?> 620w,
                         <?= $article->getArticleImage() ?> 540w,
                         <?= $article->getArticleImage() ?> 320w"
                 sizes="(min-width:1200px) 620px,
                        (min-width:1000px) 430px,
                        (min-width:620px)  580px, 280px">
        <?php } ?>
        <figcaption>
            <p class="date"><?= $article->getPublishedTime() ?></p>
            <p class="title"><?= Html::a(Html::encode($article['lang']['title']), $article->getUrl(), []) ?></p>
        </figcaption>
    </figure>
    <div class="desc"><?= $article['lang']['description'] ?></div>
</div>
