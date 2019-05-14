<?php

use yii\helpers\Html;
//
use frontend\modules\articles\models\Article;

/** @var $model Article */

$this->title = $model['lang']['title'];
$this->context->breadcrumbs[] = $this->title;
?>

<div class="main-new">
    <div class="new-description">
        <div class="data-news"><?= $model->getPublishedTime() ?></div>
        <div class="title-news"><?= $model['lang']['title'] ?></div>
        <div class="short-new"><?= $model['lang']['full_description'] ?></div>
    </div>
    <div class="img-for-new">
        <?= Html::img($model->getArticleImage()) ?>
    </div>
</div>
<article class="article text-new">
    <div class="article-text"><?= $model['lang']['content'] ?></div>
</article>