<?php if (!empty($articles)) { ?>
    <section class="last-news">
        <div class="orders-news-box">
            <h3 class="news-tittleh3"><?= Yii::t('app', 'Information for partners') ?></h3>

            <div class="last-news_cnt cf">

                <?php foreach ($articles as $article) { ?>
                    <?= $this->render('_article', ['article' => $article]) ?>
                <?php } ?>

            </div>

        </div>
    </section>
<?php } ?>