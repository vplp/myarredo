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
 * @var \frontend\modules\catalog\models\Factory $model
 */

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;

$bundle = AppAsset::register($this);

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
                            <?= Html::img(Factory::getImage($model['image_link'])); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="descr">

                            <?= Html::tag(
                                'h1',
                                (($this->context->SeoH1)
                                    ? $this->context->SeoH1
                                    : Yii::t('app', 'Мебель') . ' ' . $model['title'] . ' ' . Yii::t('app', 'в') . ' ' . Yii::$app->city->getCityTitleWhere()),
                                ['class' => 'title-text']
                            ); ?>

                            <div class="fact-link">
                                <?= Html::a(
                                    $model['url'],
                                    'https://' . $model['url'],
                                    [
                                        'target' => '_blank',
                                        'rel' => 'nofollow'
                                    ]
                                ); ?>
                            </div>

                            <div class="fact-assort-wrap">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#all-product">
                                            <?= Yii::t('app', 'Все предметы мебели') ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#all-collection">
                                            <?= Yii::t('app', 'Все коллекции') ?>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="all-product" class="tab-pane fade in active">
                                        <ul class="list">
                                            <?php
                                            $FactoryTypes = Factory::getFactoryTypes($model['id']);

                                            foreach ($FactoryTypes as $item) {

                                                $params = Yii::$app->catalogFilter->params;

                                                $params[$keys['factory']][] = $model['alias'];
                                                $params[$keys['type']][] = $item['alias'];

                                                echo Html::beginTag('li') .
                                                    Html::a(
                                                        $item['title'] . ' <span>' . $item['count'] . '</span>',
                                                        Yii::$app->catalogFilter->createUrl($params)
                                                    ) .
                                                    Html::endTag('li');

                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div id="all-collection" class="tab-pane fade">
                                        <ul class="list">
                                            <?php
                                            $FactoryCollection = Factory::getFactoryCollection($model['id']);

                                            foreach ($FactoryCollection as $item) {

                                                $params = Yii::$app->catalogFilter->params;

                                                $params[$keys['factory']][] = $model['alias'];
                                                $params[$keys['collection']][] = $item['id'];

                                                echo Html::beginTag('li') .
                                                    Html::a(
                                                        $item['title'] . ' <span>' . $item['count'] . '</span>',
                                                        Yii::$app->catalogFilter->createUrl($params)
                                                    ) .
                                                    Html::endTag('li');

                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <?= $this->render(
                                'parts/_factory_files',
                                [
                                    'model' => $model
                                ]
                            ); ?>

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
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="one-filter">
                            <h4>
                                <?= Yii::t('app', 'Category') ?>
                            </h4>
                            <ul class="list">
                                <?php
                                $key = 1;
                                $FactoryCategory = Factory::getFactoryCategory([$model['id']]);

                                foreach ($FactoryCategory as $item) {
                                    $params = Yii::$app->catalogFilter->params;

                                    $params[$keys['factory']][] = $model['alias'];
                                    $params[$keys['category']][] = $item['alias'];

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
                        <div class="cat-prod catalog-wrap">

                            <?php foreach ($product as $item) {
                                echo $this->render('/category/_list_item', [
                                    'model' => $item,
                                    'factory' => [$model->id => $model]
                                ]);
                            } ?>

                            <div class="one-prod-tile last">
                                <div class="img-cont">
                                    <img src="<?= $bundle->baseUrl ?>/img/factory.svg" alt="">
                                </div>
                                <a class="view-all"
                                   href="<?= Yii::$app->catalogFilter->createUrl(Yii::$app->catalogFilter->params + [$keys['factory'] => $model['alias']]) ?>">
                                    <?= Yii::t('app', 'Смотреть полный каталог') ?>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <?= $this->context->SeoContent ?>

            </div>
        </div>
    </div>
</main>
