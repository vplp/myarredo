<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Factory;

/**
 * @var $pages \yii\data\Pagination
 * @var $model \frontend\modules\catalog\models\ProductStatsDays
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?php if (!empty($models)) { ?>
                <?= $this->render('_form_filter', [
                    'model' => $model,
                    'params' => $params,
                ]); ?>

                <div class="cat-prod-wrap">
                    <div class="cat-prod">

                        <?php foreach ($models as $model) { ?>
                            <?= Html::beginTag('a', [
                                'href' => Url::toRoute([
                                    '/catalog/factory-stats/view',
                                    'alias' => $model['factory']['alias'],
                                    'start_date' => Yii::$app->request->get('start_date'),
                                    'end_date' => Yii::$app->request->get('end_date'),
                                ]),
                                'class' => 'one-prod-tile'
                            ]); ?>

                            <div class="img-cont">

                                <?= Html::img(Factory::getImageThumb($model['factory']['image_link'])) ?>

                                <div class="brand"><?= $model['views'] ?></div>

                            </div>

                            <div class="item-infoblock">
                                <?= $model['factory']['title'] ?>
                            </div>

                            <?= Html::endTag('a'); ?>
                        <?php } ?>

                    </div>
                    <div class="pagi-wrap">
                        <?= frontend\components\LinkPager::widget([
                            'pagination' => $pages,
                        ]) ?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="text-center">
                    <?= Yii::t('yii', 'No results found.'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
