<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url, ArrayHelper
};
use kartik\grid\GridView;
//
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\{
    FactoryPromotion, Product, FactoryProduct, FactoryPromotionRelProduct
};

/**
 * @var \frontend\modules\catalog\models\FactoryPromotion $model
 * @var \frontend\modules\catalog\models\FactoryProduct $modelProduct
 */

$this->title = Yii::t('app', 'Рекламировать');

?>

<main>
    <div class="page create-sale page-reclamations">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <p class="reclamation-p">
                        <?= Yii::t('app', 'Для проведения рекламной кампании вы выбрали') ?> <span
                                id="count-products"> <?= count($model->products) ?> </span>
                        <span class="for-green"> <?= Yii::t('app', 'товаров') ?> </span>
                    </p>

                    <div id="list-product">
                        <?php foreach ($model->products as $product) :
                            echo '<div>' .
                                $product->lang->title .
                                Html::img(Product::getImageThumb($product['image_link']), ['width' => 50]) .
                                '</div>';
                        endforeach; ?>
                    </div>

                    <div id="factorypromotion-city_ids">
                        <div class="form-group">
                            <?= Html::label($model->getAttributeLabel('country_id')) ?>
                            <div class="input-group">
                                <?= $model->country->lang->title ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::label($model->getAttributeLabel('cities')) ?>
                            <div id="factorypromotion-city_ids-2" class="input-group">
                                <?php
                                foreach ($model->cities as $city) {
                                    echo Html::label($city->lang->title);
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::label($model->getAttributeLabel('views')) ?>
                        <div class="input-group">
                            <?= $model->views ?>
                        </div>
                    </div>

                    <div class="promotion-title-label">
                        <?= Yii::t('app', 'Стоимость размещения товара в рекламе') ?>
                        <span id="cost_products"><?= 1000 * count($model->products) ?></span>
                        <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                    </div>
                    <div class="promotion-title-label">
                        <?= Yii::t('app', 'Стоимость размещения рекламы в поиске') ?>
                        <span id="cost_of_views"><?= FactoryPromotion::getCountOfViews($model->views, $model->country_id) ?></span>
                        <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                    </div>
                    <div class="promotion-title-label">
                        <?= Yii::t('app', 'Общая стоимость рекламной кампании') ?>
                        <span id="cost"><?= $model->amount ?></span>
                        <span class="current-item"> <?= Yii::t('app', 'руб') ?> </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
