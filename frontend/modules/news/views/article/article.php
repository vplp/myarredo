<?php

use yii\helpers\Html;
use frontend\modules\news\models\Article;
use frontend\modules\news\widgets\newslist\NewsList;
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\catalog\models\Factory;

/** @var $model Article */

$bundle = AppAsset::register($this);

$this->title = $model['lang']['title'];
$keys = Yii::$app->catalogFilter->keys;
?>

<div class="myarredo-blog-wrap">
    <div class="myarredo-blogbox">
        <div class="myarredo-blogartbox">

            <!-- Контент старт -->
            <div class="single-articlebox" itemscope itemtype="http://schema.org/Article">
                <h1 class="article-title"><?= $model['lang']['title'] ?></h1>
                <article class="article-textbox" itemprop="articleBody">
                    <?= $model['lang']['content'] ?>
                </article>

                <?php if ($model['category']) { ?>
                    <div>
                        <?= Yii::t('app', 'Category') ?>:
                        <?php
                        $paramsUrl = [];

                        if ($model['factory']) {
                            $paramsUrl[$keys['factory']][] = $model['factory']['alias'];
                        }
                        $paramsUrl[$keys['category']] = $model['category'][Yii::$app->languages->getDomainAlias()];

                        echo Html::a(
                            $model['category']['lang']['title'],
                            Yii::$app->catalogFilter->createUrl($paramsUrl)
                        ); ?>
                    </div>
                <?php } ?>

                <?php if ($model['factory']) { ?>
                    <div>
                        <?= Yii::t('app', 'Factory') ?>:
                        <?= Html::a(
                            $model['factory']['title'],
                            Factory::getUrl($model['factory']['alias'])
                        ); ?>
                    </div>
                <?php } ?>

                <?php if ($model['styles']) { ?>
                    <div>
                        <?= Yii::t('app', 'Стили мебели') ?>:
                        <?php
                        $array = [];
                        foreach ($model['styles'] as $item) {
                            $paramsUrl = [];

                            if ($model['factory']) {
                                $paramsUrl[$keys['factory']][] = $model['factory']['alias'];
                            }
                            $paramsUrl[$keys['style']][] = $item[Yii::$app->languages->getDomainAlias()];

                            $array[] = Html::a(
                                $item['lang']['title'],
                                Yii::$app->catalogFilter->createUrl($paramsUrl)
                            );
                        }
                        echo implode('; ', $array);
                        ?>
                    </div>
                <?php } ?>

                <?php if ($model['types']) { ?>
                    <div>
                        <?= Yii::t('app', 'Types') ?>:
                        <?php
                        $array = [];
                        foreach ($model['types'] as $item) {
                            $paramsUrl = [];

                            if ($model['factory']) {
                                $paramsUrl[$keys['factory']][] = $model['factory']['alias'];
                            }
                            $paramsUrl[$keys['type']][] = $item[Yii::$app->languages->getDomainAlias()];

                            $array[] = Html::a(
                                $item['lang']['title'],
                                Yii::$app->catalogFilter->createUrl($paramsUrl)
                            );
                        }
                        echo implode('; ', $array);
                        ?>
                    </div>
                <?php } ?>

            </div>
            <!-- Контент конец -->

            <!-- Сайдбар старт -->
            <?= NewsList::widget(['view' => 'articles_assidebox', 'limit' => 2]) ?>
            <!-- Сайдбар конец -->

            <!-- Похожие статьи старт -->
            <?= NewsList::widget(['view' => 'articles_similarbox', 'limit' => 4]) ?>
            <!-- Похожие статьи конец -->

        </div>
    </div>
</div>

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?= $model->getUrl(true) ?>"
    },
    "headline": "<?= $model['lang']['title'] ?>",
    "image": [
        "<?= Article::getImageThumb($model['image_link']) ?>"
    ],
    "datePublished": "<?= date('Y-m-d', $model->published_time) ?>",
    "dateModified": "<?= date('Y-m-d', $model->updated_at) ?>",
    "author": {
        "@type": "Person",
        "name": "MyArredo"
    },
    "publisher": {
        "@type": "Organization",
        "name": "MyArredoFamily",
        "logo": {
            "@type": "ImageObject",
            "url": "<?= 'https://img.' . DOMAIN_NAME . '.' . DOMAIN_TYPE ?>/uploads/myarredo-ico.jpg"
        }
    }
}
</script>
