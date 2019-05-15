<?php

use yii\helpers\Html;
//
use frontend\modules\articles\models\Article;

/** @var $model Article */

$this->title = $model['lang']['title'];
$this->context->breadcrumbs[] = $this->title;
?>
<div class="myarredo-blog-wrap">
    <div class="myarredo-blog">
        <div class="single-articlebox">
            <div class="new-description">
                <div class="data-news"><?= $model->getPublishedTime() ?></div>
                <div class="title-news"><?= $model['lang']['title'] ?></div>
                <div class="short-new"><?= $model['lang']['description'] ?></div>
            </div>
            <div class="img-for-new">
                <?= Html::img($model->getArticleImage()) ?>
            </div>
        </div>
        <article class="article text-new">
            <div class="article-text"><?= $model['lang']['content'] ?></div>
        </article>
    </div>
</div>