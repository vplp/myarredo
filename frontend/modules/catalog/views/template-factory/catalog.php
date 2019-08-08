<?php

use frontend\modules\catalog\models\Product;
use frontend\modules\catalog\widgets\filter\{
    ProductFilter
};

/**
 * @var $pages \yii\data\Pagination
 * @var $model Product
 */

$this->title = $this->context->title;
?>

<main>
    <div class="page category-page">
        <div class="container large-container">
            <div class="cat-content">
                <div class="row">

                    <div class="col-md-3 col-lg-3">

                        <?= ProductFilter::widget([
                            'route' => '/factory/' . $factory['alias'] . '/catalog',
                            'category' => $category,
                            'types' => $types,
                            'subtypes' => $subtypes,
                            'style' => $style,
                            'colors' => $colors,
                            'price_range' => $price_range,
                        ]); ?>

                    </div>

                    <div class="col-md-9 col-lg-9">
                        <div class="cont-area">
                            <div class="cat-prod-wrap">
                                <div class="cat-prod">

                                    <?php foreach ($models as $model) {
                                        echo $this->render('/category/_list_item', [
                                            'model' => $model,
                                            'factory' => [$factory->id => $factory],
                                        ]);
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
            </div>
        </div>
</main>
