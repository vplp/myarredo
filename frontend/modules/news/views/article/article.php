<?php

use yii\helpers\Url;
use yii\helpers\Html;
use frontend\themes\vents\widgets\share\YandexShareWidget;
use frontend\themes\vents\widgets\news\SimilarNews;

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
$this->title = $model['lang']['title'];
echo Yii::$app->controller->renderPartial('/part/seo',['article' => $model]);

?>

    <div class="news-part1 clearfix">

        <div class="news-img">
            <figure class="img1">
                <?php if ($model->getArticleImage()): ?>
                    <img src="<?= $model->getArticleImage() ?>" alt="news" srcset="<?= $model->getArticleImage() ?> 620w, <?= $model->getArticleImage() ?> 540w, <?= $model->getArticleImage() ?> 320w" sizes="(min-width:1200px) 620px, (min-width:1000px) 430px, (min-width:620px)  580px, 280px">
                <?php endif; ?>
            </figure>
        </div>
        <div class="news-body">
            <div class="date"><?= $model->getPublishedTime(); ?></div>
            <div class="title"><a href="#"><?= $model['lang']['title'] ?></a></div>
            <div class="desc"><?= $model['lang']['description'] ?></div>
        </div>
    </div>
</div>
<div class="news-body-center clearfix">
    <div class="left-part">
        <div class="clearfix">

            <?= $model['lang']['content']; ?>

        </div>

        <?php if (!empty($model->getArticleGallery())): ?>
            <section class="news-slider clearfix">
                <h2><?= Yii::t('app', 'Event gallery') ?>:</h2>
                <div class="sl-big"><img src="" alt="photo"></div>
                <div id="slider1">
                    <a class="buttons prev" href="#">left</a>
                    <div class="viewport">
                        <ul class="overview">
                            <?php foreach($model->getArticleGallery() as $img): ?>
                                <li><img src="<?= $img ?>" /></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <a class="buttons next" href="#">right</a>
                </div>
            </section>
        <?php endif; ?>

        <div class="social"><?= Yii::t('app', 'Share') ?>:
            <?=
            YandexShareWidget::widget([
                'services' => 'facebook,vkontakte,twitter,gplus',
                'meta' => [
                    //'fb_app_id' => '150935738345402',
                    'type' => 'none',
                    'image' => $model->getArticleImage(),
                    'title' => Html::encode($model['lang']['title']),
                    'description' => Html::encode(strip_tags($model['lang']['description'])),
                    'url' => Yii::$app->getRequest()->hostInfo . Url::current(),
                ]
            ])
            ?>
        </div>
    </div>

    <div class="right-part">

        <p><?= Yii::t('app', 'Similar news') ?>:</p>
        <?= SimilarNews::widget() ?>

    </div>