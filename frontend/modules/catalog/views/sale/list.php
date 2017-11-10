<?php

use yii\helpers\Html;
use frontend\components\Breadcrumbs;

use frontend\modules\catalog\widgets\filter\{
    ProductFilter
};

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\Sale
 */

?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="row">
                <?= Html::tag('h1', $this->context->title); ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">
                    <div class="col-md-3 col-lg-3">

                        <?= ProductFilter::widget([
                            'route' => '/catalog/sale/list',
                            'category' => $category,
                            'types' => $types,
                            'style' => $style,
                            'factory' => $factory,
                        ]); ?>

                    </div>
                    <div class="col-md-9 col-lg-9">
                        <div class="cont-area">

                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php if (!empty($models)): ?>
                                        <?php foreach ($models as $model): ?>
                                            <?= $this->render('_list_item', ['model' => $model]) ?>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Не найдено</p>
                                    <?php endif; ?>

                                </div>
                                <div class="pagi-wrap">

                                    <?=
                                    yii\widgets\LinkPager::widget([
                                        'pagination' => $pages,
                                        'registerLinkTags' => true,
                                        'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                                        'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                                    ]);
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="comp-advanteges">

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
