<?php

$this->title = $this->context->title;
?>

<section class="amrita-news">
    <div class="title-sec"><?= Yii::t('app', 'Articles') ?></div>

    <?php if (isset($models[0])): ?>
        <div class="main-new">
            <?= $this->render('_main_article', ['article' => $models[0]]) ?>
        </div>
    <?php endif; ?>

    <div class="all-news">
        <?php for ($i = 1; $i < count($models); $i++): ?>
            <?php if (isset($models[$i])): ?>
                <?= $this->render('_article', ['article' => $models[$i]]) ?>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <div class="catalog">
        <div class="pages">
            <?=
            yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'registerLinkTags' => true,
            ]);
            ?>
        </div>
    </div>
</section>