<?php
use yii\helpers\Html;

$this->title = $model['lang']['title'];
echo $this->render('/part/seo', ['article' => $model]);
?>

<div class="news-img">
    <figure class="img1">
        <?php if ($model->getArticleImage()): ?>
            <img src="<?= $model->getArticleImage() ?>" alt="news"
                 srcset="<?= $model->getArticleImage() ?> 620w, <?= $model->getArticleImage() ?> 540w, <?= $model->getArticleImage() ?> 320w"
                 sizes="(min-width:1200px) 620px, (min-width:1000px) 430px, (min-width:620px)  580px, 280px">
        <?php endif; ?>
    </figure>
</div>
<div class="news-body">
    <div class="date"><?= $model->getPublishedTime() ?></div>
</div>

<?= Html::tag('h1', $model['lang']['title']) ?>

<?= $model['lang']['content'] ?>

<?= Yii::t('news', 'News') ?>
