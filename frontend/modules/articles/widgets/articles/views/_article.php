<?php

use yii\helpers\Html;
use frontend\modules\articles\models\Article;

/** @var $article Article */

?>

<div class="articles_i cf">
    <div class="articles_i_l">
        <?php if (Article::isImage($article['image_link'])) { ?>
            <div class="articles_i_img">
                <?= Html::img(
                    Article::getImageThumb($article['image_link']),
                    ['alt' => $article['lang']['title']]
                ) ?>
            </div>
        <?php } ?>
    </div>
    <div class="articles_i_r">
        <?= Html::a(Html::encode($article['lang']['title']), $article->getUrl(), ['class' => 'articles_i_t']) ?>
        <div class="articles_i_tx"><?= $article['lang']['description'] ?></div>
    </div>
</div>
