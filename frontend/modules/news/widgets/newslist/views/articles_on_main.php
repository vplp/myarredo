<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\news\models\Article;

/** @var $articles Article[] */
/** @var $article Article */

?>

<?php if (!empty($articles)) { ?>
    <div class="articles-list">
        <div class="container large-container">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="section-header">
                        <h2 class="section-title">
                            <?= Yii::t('app', 'News') ?>
                        </h2>
                        <?= Html::a(
                            Yii::t('app', 'Смотреть все новости'),
                            Url::toRoute('/news/list/index'),
                            ['class' => 'sticker']
                        ) ?>
                    </div>

                    <div class="article-similarbox">

                        <div class="article-similar">

                            <?php foreach ($articles as $article) { ?>
                                <div class="article-similar-item">
                                    <div class="article-item-box">
                                        <a class="article-item-imglink" href="<?= $article->getUrl() ?>">
                                            <div class="article-item-img">
                                                <?= Html::img('/', [
                                                    'class' => 'lazy',
                                                    'data-src' => $article->getArticleImage(),
                                                    'width' => '290px',
                                                    'height' => '190px'
                                                ]) ?>
                                            </div>
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
                                                    <i class="fa fa-calendar"
                                                       aria-hidden="true"></i> <?= $article->getPublishedTime() ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>
<?php } ?>
