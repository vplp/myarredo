<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
//
use frontend\modules\catalog\models\{Product, ItalianProduct, ItalianProductLang, ProductLang};
use frontend\modules\catalog\widgets\filter\{
    ProductSorting, ProductFilter
};
use frontend\modules\catalog\widgets\paginator\PageChanger;
use frontend\modules\catalog\widgets\product\ViewedProducts;
use frontend\modules\catalog\widgets\product\ProductsNovelties;

/**
 * @var $pages \yii\data\Pagination
 * @var $model Product
 * @var $models Product[]
 *
 * @var $category
 * @var $types
 * @var $subtypes
 * @var $style
 * @var $factory
 * @var $collection
 * @var $colors
 * @var $price_range
 */

$this->title = $this->context->title;

$keys = Yii::$app->catalogFilter->keys;
$params = Yii::$app->catalogFilter->params;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div>

                    <?= Html::tag('h1', Yii::$app->metatag->seo_h1) ?>

                    <?php if (isset($params[$keys['factory']]) && count($params[$keys['factory']]) == 1) {
                        echo Html::a(
                            Yii::t('app', 'Перейти на страницу фабрики'),
                            ['/catalog/factory/view', 'alias' => $params[$keys['factory']][0]]
                        );
                    } ?>

                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>

                </div>

                <?php if (empty($params) || (count($params) == 1 && isset($params[$keys['category']]))) {
                    echo ProductsNovelties::widget([
                        'modelPromotionItemClass' => Product::class,
                        'modelPromotionItemLangClass' => ProductLang::class,
                        'modelClass' => ItalianProduct::class,
                        'modelLangClass' => ItalianProductLang::class,
                    ]);
                } ?>

                <div class="cat-content">
                    <?= Html::a(
                        Yii::t('app', 'Фильтры'),
                        'javascript:void(0);',
                        ['class' => 'js-filter-btn']
                    ) ?>
                    <div class="clearfix">
                        <div class="col-md-3 col-lg-3 js-filter-modal">

                            <?= ProductFilter::widget([
                                'route' => '/catalog/category/list',
                                'category' => $category,
                                'types' => $types,
                                'subtypes' => $subtypes,
                                'style' => $style,
                                'factory' => $factory,
                                'collection' => $collection,
                                'colors' => $colors,
                                'price_range' => $price_range,
                            ]); ?>

                        </div>
                        <div class="col-md-9 col-lg-9">
                            <div class="cont-area">

                                <div class="top-bar flex">

                                    <?= ProductSorting::widget() ?>

                                    <?= PageChanger::widget(['pages' => $pages]) ?>

                                </div>

                                <div class="cat-prod-wrap">
                                    <div class="cat-prod">

                                        <?php
                                        $_factory = [];
                                        foreach ($factory as $item) {
                                            $_factory[$item['id']] = $item;
                                        }

                                        foreach ($models as $model) {
                                            echo $this->render('_list_item', ['model' => $model,
                                                'factory' => $_factory,]);
                                        } ?>

                                    </div>
                                    <div class="pagi-wrap">

                                        <?= frontend\components\LinkPager::widget(['pagination' => $pages,]) ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="comp-advanteges">

                            <?php if (!Yii::$app->request->get('page')) { ?>
                                <?= Yii::$app->metatag->seo_content ?>
                            <?php } ?>
                        </div>
                    </div>

                    <?= ViewedProducts::widget([
                        'modelClass' => Product::class,
                        'modelLangClass' => ProductLang::class,
                        'cookieName' => 'viewed_products'
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</main>
