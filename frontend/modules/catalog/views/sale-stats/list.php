<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\{
    Sale, SaleStatsDays
};

/**
 * @var $pages \yii\data\Pagination
 *
 * @var $model SaleStatsDays
 * @var $item SaleStatsDays
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
                                    '/catalog/sale-stats/view',
                                    'id' => $item['sale']['id'],
                                    'start_date' => Yii::$app->request->get('start_date'),
                                    'end_date' => Yii::$app->request->get('end_date'),
                                ]),
                                'class' => 'one-prod-tile'
                            ]); ?>

                            <div class="img-cont">
                                <?= Html::img(Sale::getImageThumb($item['sale']['image_link']),['width' => '317',
            'height' => '188']) ?>
                                <div class="brand">
                                    <?= Yii::t('app', 'Просмотры') ?>: <?= $item['views'] ?>
                                    <?= Yii::t('app', 'Заявки') ?>: <?= $item['requests'] ?>
                                </div>
                            </div>

                            <div class="item-infoblock">
                                <?= Sale::getStaticTitle($item['sale']) ?>
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
