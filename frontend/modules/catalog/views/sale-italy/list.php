<?php

use yii\helpers\Html;
//
use frontend\components\Breadcrumbs;
use frontend\modules\catalog\widgets\filter\ItalianProductFilter;

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\ItalianProduct
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row">

                    <?= Html::tag('h1', ($this->context->SeoH1 != '')
                        ? $this->context->SeoH1
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
                            <?= $this->context->SeoContent ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
