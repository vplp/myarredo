<?php

use yii\helpers\{
    Url, Html
};
//
use frontend\modules\articles\models\Article;

/** @var $articles Article[] */
/** @var $article Article */

?>

<?php if (!empty($articles)) { ?>
    <div class="article-similarbox">
        <div class="article-similar-hr"></div>
        <div class="article-similar">

            <?php foreach ($articles as $article) { ?>
                <div class="article-similar-item">
                    <div class="article-item-box">
                        <a class="article-item-imglink" href="<?= $article->getUrl() ?>">
                            <div class="article-item-img"><?= Html::img($article->getArticleImage()) ?></div>
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
            <?php } ?>

        </div>
    </div>

<?php } ?>

