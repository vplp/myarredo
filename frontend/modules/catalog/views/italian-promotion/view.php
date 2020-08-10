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
    FactoryPromotion, IalianProduct, FactoryProduct, FactoryPromotionRelProduct
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
                        <?php foreach ($model->italianProducts as $product) :
                            echo '<div class="list-product-item">' .
                                    '<div class="list-product-img">' .
                                        Html::img(IalianProduct::getImageThumb($product['image_link']), ['width' => 200]) .
                                    '</div>' .
                                    '<div class="product-list-descr">' . 
                                        $product->lang->title .
                                    '</div>' .
                                '</div>';
                        endforeach; ?>
                    </div>

                    <div id="factorypromotion-city_ids">
                        <div class="form-group">
                            <?= Html::label($model->getAttributeLabel('country_id')) ?>
                            <div class="input-group">
                                <?= $model->country->getTitle() ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::label($model->getAttributeLabel('cities')) ?>
                            <div id="factorypromotion-city_ids-2" class="input-group">
                                <?php
                                foreach ($model->cities as $city) {
                                    echo Html::label($city->getTitle());
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
                    <div class="form-group total-stats">
                        <table class="table table-bordered table-totalorder">
                            <thead>
                                <tr>
                                    <th><?= Yii::t('app', 'Наименование услуг') ?></th>
                                    <th><?= Yii::t('app', 'Цена') ?></th>
                                    <th><?= Yii::t('app', 'Валюта') ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td><?= Yii::t('app', 'Стоимость размещения товара в рекламе') ?></td>
                                    <td><span id="cost_products"><?= 1000 * count($model->italianProducts) ?></span></td>
                                    <td><span class="current-item"> <?= Yii::t('app', 'руб') ?> </span></td>
                                </tr>
                                <tr>
                                    <td><?= Yii::t('app', 'Стоимость размещения рекламы в поиске') ?></td>
                                    <td><span id="cost_of_views"><?= FactoryPromotion::getCountOfViews($model->views, $model->country_id) ?></span></td>
                                    <td><span class="current-item"> <?= Yii::t('app', 'руб') ?> </span></td>
                                </tr>
                                <tr>
                                    <td> <?= Yii::t('app', 'Общая стоимость рекламной кампании') ?></td>
                                    <td><strong><span id="cost"><?= $model->amount ?></span></strong></td>
                                    <td><span class="current-item"> <?= Yii::t('app', 'руб') ?> </span></td>
                                </tr>
                            </tbody>
                        
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
