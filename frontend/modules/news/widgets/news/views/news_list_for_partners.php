<?php if (!empty($articles)) { ?>
    <section class="last-news">
        <div class="container cf">
            <h3><?= Yii::t('app', 'Information for partners') ?></h3>

            <div class="last-news_cnt cf">

                <?php foreach ($articles as $article) { ?>
                    <?= $this->render('_article', ['article' => $article]) ?>
                <?php } ?>

            </div>

        </div>
    </section>
<?php } ?>