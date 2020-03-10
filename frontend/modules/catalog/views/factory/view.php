<?php

use yii\helpers\{
    Url, Html
};
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\models\{
    Factory, Category
};

/**
 * @var $model Factory
 * @var $italianProduct array
 * @var $saleProduct array
 * @var $product array
 * @var $hostInfoSale string
 */

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;

$bundle = AppAsset::register($this);

$h1 = Yii::$app->metatag->seo_h1
    ? Yii::$app->metatag->seo_h1
    : Yii::t('app', 'Мебель') . ' ' . $model['title'];
$h1 .= !Yii::$app->metatag->seo_h1 && Yii::$app->city->domain != 'com'
    ? ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere()
    : '';

?>

<main>
    <div class="page factory-page">
        <div class="container-wrap">
            <div class="container large-container">

                <div class="row">
                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>
                </div>

                <div class="row factory-det">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="fact-img">
                            <?= Html::img(Factory::getImage($model['image_link'])) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="descr">

                            <?= Html::tag(
                                'h1',
                                $h1,
                                ['class' => 'title-text']
                            ); ?>

                            <div class="fact-link">
                                <?= Html::a(
                                    $model['url'],
                                    'http://' . $model['url'],
                                    [
                                        'target' => '_blank',
                                        'rel' => 'nofollow'
                                    ]
                                ); ?>
                            </div>

                            <div class="fact-assort-wrap">

                                <?= $this->render('parts/_tabs', [
                                    'model' => $model
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row factory-text">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <!--<div class="header-border">
                            <div class="text-header">
                                В ассортименте представлена
                                мебель для наиболее
                                значимых и важных зон
                                каждого дома
                            </div>
                        </div>-->
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="text">
                            <?= $model['lang']['content']; ?>
                            <?= $model->getVideo(); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="one-filter">
                            <div class="">
                                <?= Yii::t('app', 'Category') ?>
                            </div>
                            <ul class="list">
                                <?php
                                $key = 1;
                                $FactoryCategory = Factory::getFactoryCategory([$model['id']]);

                                foreach ($FactoryCategory as $item) {
                                    $params = Yii::$app->catalogFilter->params;

                                    $params[$keys['factory']][] = $model['alias'];
                                    $params[$keys['category']][] = Yii::$app->city->domain != 'com' ? $item['alias'] : $item['alias2'];

                                    ?>
                                    <li>
                                        <a href="<?= Yii::$app->catalogFilter->createUrl($params) ?>">
                                            <div class="left-group">
                                                <div class="img-cont">
                                                    <?= Html::img(Category::getImage($item['image_link3'])) ?>
                                                </div>
                                                <?= $item['title'] ?>
                                            </div>
                                            <span class="count">
                                                <?= $item['count'] ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">

                        <?php /*if ($italianProduct) { ?>
                            <?= Html::tag('h2', Yii::t('app', 'Sale in Italy')) ?>
                            <div class="cat-prod catalog-wrap">
                                <?php foreach ($italianProduct as $key => $item) {
                                    if ($key == 5) { ?>
                                        <div class="one-prod-tile last">
                                            <div class="img-cont">
                                                <?= Html::img($bundle->baseUrl . '/img/factory.svg') ?>
                                            </div>

                                            <?= Html::a(
                                                Yii::t('app', 'Смотреть полный каталог'),
                                                Yii::$app->catalogFilter->createUrl(
                                                    Yii::$app->catalogFilter->params +
                                                    [$keys['factory'] => $model['alias']],
                                                    '/catalog/sale-italy/list'
                                                ),
                                                ['class' => 'view-all', 'rel' => 'nofollow']
                                            ) ?>
                                        </div>
                                    <?php } else {
                                        echo $this->render('/sale-italy/_list_item', [
                                            'model' => $item,
                                            'factory' => [$model->id => $model]
                                        ]);
                                    }
                                } ?>
                            </div>
                        <?php }*/ ?>

                        <?php if ($saleProduct) { ?>
                            <?= Html::tag('h2', Yii::t('app', 'Sale')) ?>
                            <div class="cat-prod catalog-wrap">
                                <?php foreach ($saleProduct as $key => $item) {
                                    if ($key == 5) { ?>
                                        <div class="one-prod-tile last">
                                            <div class="img-cont">
                                                <?= Html::img($bundle->baseUrl . '/img/factory.svg') ?>
                                            </div>

                                            <?= Html::a(
                                                Yii::t('app', 'Смотреть полный каталог'),
                                                Yii::$app->catalogFilter->createUrl(
                                                    Yii::$app->catalogFilter->params +
                                                    [$keys['factory'] => $model['alias']],
                                                    '/catalog/sale/list'
                                                ),
                                                ['class' => 'view-all', 'rel' => 'nofollow']
                                            ) ?>
                                        </div>
                                    <?php } else {
                                        echo $this->render('/sale/_list_item', [
                                            'model' => $item,
                                            'factory' => [$model->id => $model],
                                            'hostInfo' => $hostInfoSale
                                        ]);
                                    }
                                } ?>
                            </div>
                        <?php } ?>

                        <?php if ($product) { ?>
                            <?= Html::tag('h2', Yii::t('app', 'Catalog of furniture')) ?>
                            <div class="cat-prod catalog-wrap">
                                <?php foreach ($product as $item) {
                                    echo $this->render('/category/_list_item', [
                                        'model' => $item,
                                        'factory' => [$model->id => $model]
                                    ]);
                                } ?>
                                <div class="one-prod-tile last">
                                    <div class="img-cont">
                                        <?= Html::img($bundle->baseUrl . '/img/factory.svg') ?>
                                    </div>
                                    <?= Html::a(
                                        Yii::t('app', 'Смотреть полный каталог'),
                                        Yii::$app->catalogFilter->createUrl(
                                            Yii::$app->catalogFilter->params +
                                            [$keys['factory'] => $model['alias']]
                                        ),
                                        ['class' => 'view-all', 'rel' => 'nofollow']
                                    ) ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>

                <?= Yii::$app->metatag->seo_content ?>

            </div>
        </div>
    </div>
</main>
