<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductStatsDays
};

/**
 * @var $pages \yii\data\Pagination
 *
 * @var $model ItalianProductStatsDays
 * @var $item ItalianProductStatsDays
 */

$this->title = $this->context->title;

?>
<style>
    .category-page .cat-prod .one-prod-tile .background,
    .std-slider .background{
        -webkit-filter: none;
        filter: none;
    }
</style>
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
                                    '/catalog/sale-italy-stats/view',
                                    'id' => $item['italianProduct']['id'],
                                    'start_date' => Yii::$app->request->get('start_date'),
                                    'end_date' => Yii::$app->request->get('end_date'),
                                ]),
                                'class' => 'one-prod-tile'
                            ]); ?>

                            <div class="img-cont">
                                <?= Html::img(ItalianProduct::getImageThumb($item['italianProduct']['image_link']),['width' => '317',
            'height' => '188']) ?>
                                <div class="brand">
                                    <?= Yii::t('app', 'Просмотры') ?>: <?= $item['views'] ?>
                                    <?= Yii::t('app', 'Заявки') ?>: <?= $item['requests'] ?>
                                </div>
                            </div>

                            <div class="item-infoblock">
                                <?= ItalianProduct::getStaticTitle($item['italianProduct']) ?>
                            </div>

                            <?= Html::endTag('a'); ?>
                        <?php } ?>
                    </div>
                    <?php if ($pages->totalCount > $pages->defaultPageSize) { ?>
                        <div class="pagi-wrap">
                            <?= frontend\components\LinkPager::widget([
                                'pagination' => $pages,
                            ]) ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="text-center">
                        <?= Yii::t('yii', 'No results found.'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
