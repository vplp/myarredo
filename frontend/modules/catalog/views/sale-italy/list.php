<?php

use yii\helpers\Html;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\widgets\filter\ItalianProductFilter;
use frontend\modules\catalog\widgets\product\ViewedProducts;
use frontend\modules\catalog\models\ItalianProduct;

/**
 * @var $pages \yii\data\Pagination
 * @var $model ItalianProduct
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row">

                    <?= Html::tag('h1', (Yii::$app->metatag->seo_h1 != '')
                        ? Yii::$app->metatag->seo_h1
                        : Yii::t('app', 'Sale in Italy')); ?>

                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>

                </div>
                <div class="cat-content">
                    <div class="row">
                        <div class="col-md-3 col-lg-3">

                            <?= ItalianProductFilter::widget([
                                'route' => '/catalog/sale-italy/list',
                                'category' => $category,
                                'types' => $types,
                                'style' => $style,
                                'factory' => $factory
                            ]); ?>

                        </div>
                        <div class="col-md-9 col-lg-9">
                            <div class="cont-area">

                                <div class="cat-prod-wrap">
                                    <div class="cat-prod">

                                        <?php
                                        if (!empty($models)) {
                                            foreach ($models as $model) {
                                                echo $this->render('_list_item', ['model' => $model]);
                                            }
                                        } else {
                                            echo '<p>' . Yii::t('app', 'Не найдено') . '</p>';
                                        } ?>

                                    </div>
                                    <div class="pagi-wrap">

                                        <?= frontend\components\LinkPager::widget([
                                            'pagination' => $pages,
                                        ]) ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="comp-advanteges">
                            <?= Yii::$app->metatag->seo_content ?>
                        </div>
                    </div>

                    <?= ViewedProducts::widget(['modelClass' => ItalianProduct::class, 'cookieName' => 'viewed_sale_italy']) ?>

                </div>
            </div>
        </div>
    </div>
</main>
