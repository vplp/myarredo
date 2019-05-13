<?php

?>

<h2><?= Yii::t('app', 'News') ?></h2>
<div class="news-container">
    <?php foreach ($models as $article) { ?>
        <?= $this->render('_list_item', ['article' => $article]) ?>
    <?php } ?>
</div>

<div class="pages">
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $pages,
        'registerLinkTags' => true,
    ]) ?>
</div>