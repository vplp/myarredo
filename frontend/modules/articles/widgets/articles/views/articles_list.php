<?php

use yii\helpers\Url;

?>

<?php if (!empty($articles)): ?>
    <section class="articles">
        <div class="container cf">
            <h3><?= Yii::t('front', 'Articles')?></h3>
            <a href="<?= Url::toRoute(['/articles/list/index']) ?>" class="more-page"><?= Yii::t('front', 'All articles')?></a>
            <div class="articles_cnt">

                <?php foreach ($articles as $article): ?>
                    <?= $this->render('_article', ['article' => $article]) ?>
                <?php endforeach; ?>

            </div>
            <div class="articles_b_mobile cf">
                <a href="<?= Url::toRoute(['/articles/list/index']) ?>" class="more-page"><?= Yii::t('front', 'All articles')?></a>
            </div>
        </div>
    </section>
<?php endif; ?>