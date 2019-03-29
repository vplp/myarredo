<?php

use yii\helpers\Html;

$this->title = $model['lang']['title'];
$this->context->breadcrumbs[] = $this->title;

Yii::$app->openGraph->optMetaData([
    'title' => $this->title,
    'description' => $model['lang']['description'],
    'url' => Yii::$app->request->hostInfo . Yii::$app->request->getUrl(),
    'image' => $model->getArticleImage() ? $model->getArticleImage() : '',
    'type' => 'website'
]);

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