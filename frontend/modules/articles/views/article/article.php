<?php

use yii\helpers\Html;
//
use frontend\modules\articles\models\Article;
use frontend\modules\articles\widgets\articles\ArticlesList;
/** @var $model Article */

$this->title = $model['lang']['title'];
$this->context->breadcrumbs[] = $this->title;
?>

<div class="myarredo-blog-wrap">
    <div class="myarredo-blogbox">
        <div class="myarredo-blogartbox">

            <!-- Контент старт -->
            <div class="single-articlebox">
                <div class="article-title"><?= $model['lang']['title'] ?></div>
                <article class="article-textbox">
                    <?= $model['lang']['content'] ?>
                </article>
            </div>
            <!-- Контент конец -->

            <!-- Сайдбар старт -->
            <?= ArticlesList::widget(['view' => 'articles_assidebox', 'limit' => 2]) ?>
            <!-- Сайдбар конец -->

            <!-- Похожие статьи старт -->
            <?= ArticlesList::widget(['view' => 'articles_similarbox', 'limit' => 4]) ?>
            <!-- Похожие статьи конец -->

        </div>
    </div>
</div>