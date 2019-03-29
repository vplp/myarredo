<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\ElasticSearchProduct $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page category-page">
        <div class="container-wrap">
            <div class="container large-container">
                <div class="row">
                    <?= Html::tag('h1', $this->title, []); ?>
                </div>
                <div class="cat-content">
                    <div class="row">

                        <div class="col-md-12 col-lg-12">
                            <div class="cont-area">

                                <?php if ($models) { ?>
                                    <h3><?= Yii::t('app', 'Результат поиска для') ?>
                                        <span class='label label-success'>
                                            <?= $queryParams['search'] ?>
                                        </span>
                                    </h3>

                                    <div class="cat-prod-wrap">
                                        <div class="cat-prod">
                                            <?php
                                            foreach ($models as $model) {
                                                $product = $model->product;

                                                if ($model->product != null) {
                                                    $factory = [];
                                                    $factory[$model->product['factory']['id']] = $model->product['factory'];

                                                    echo $this->render('/category/_list_item', [
                                                        'model' => $model->product,
                                                        'factory' => $factory,
                                                    ]);
                                                }
                                            } ?>
                                        </div>
                                        <div class="pagi-wrap">

                                            <?= frontend\components\LinkPager::widget(['pagination' => $pages]) ?>

                                        </div>

                                    </div>
                                <?php } else {
                                    echo Yii::t('app', 'К сожалению по данному запросу товаров не найдено');
                                } ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
