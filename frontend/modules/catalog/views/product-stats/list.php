<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Product, ProductStatsDays
};

/**
 * @var $pages \yii\data\Pagination
 *
 * @var $model ProductStatsDays
 * @var $item ProductStatsDays
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= $this->render('_form_filter', [
                'model' => $model,
                'params' => $params,
            ]); ?>

            <div class="cat-prod-wrap">
                <?php if (!empty($models)) { ?>
                    <div class="cat-prod">
                        <?php foreach ($models as $item) { ?>
                            <?= Html::beginTag('a', [
                                'href' => Url::toRoute([
                                    '/catalog/product-stats/view',
                                    'id' => $item['product']['id'],
                                    'start_date' => Yii::$app->request->get('start_date'),
                                    'end_date' => Yii::$app->request->get('end_date'),
                                ]),
                                'class' => 'one-prod-tile'
                            ]); ?>

                            <div class="img-cont">
                                <?= Html::img(Product::getImageThumb($item['product']['image_link'])) ?>
                                <div class="brand">views: <?= $item['views'] ?> requests: <?= $item['requests'] ?></div>
                            </div>

                            <div class="item-infoblock">
                                <?= Product::getStaticTitle($item['product']) ?>
                            </div>

                            <?= Html::endTag('a'); ?>
                        <?php } ?>
                    </div>
                    <div class="pagi-wrap">
                        <?= frontend\components\LinkPager::widget([
                            'pagination' => $pages,
                        ]) ?>
                    </div>
                <?php } else { ?>
                    <div class="text-center">
                        <?= Yii::t('yii', 'No results found.'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
