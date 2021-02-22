<?php

use yii\helpers\Html;
use frontend\modules\news\models\Article;

/** @var $article Article */

?>

<div class="articles_i cf">
    <div class="articles_i_l">
        <?php if ($article->getArticleImage()) { ?>
            <div class="articles_i_img">
                <?= Html::img($article->getArticleImage()) ?>
            </div>
        <?php } ?>
    </div>
    <div class="articles_i_r">
        <div class="articles_i_date"><?= $article->getPublishedTime() ?></div>
        <?= Html::a(Html::encode($article['lang']['title']), $article->getUrl(), ['class' => 'articles_i_t']) ?>
        <div class="articles_i_tx"><?= $article['lang']['description'] ?></div>
    </div>
</div>
