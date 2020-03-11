<?php

use yii\helpers\Html;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\FactoryPromotion;

/**
 * @var FactoryPromotion $model
 * @var ActiveForm $form
 */
?>

<div class="form-group">
    <?= Html::label($model->getAttributeLabel('product_ids')) ?>
    <div class="input-group">
        <?php
        $result = [];
        $products = $model->factory_id ? $model->products : $model->italianProducts;
        foreach ($products as $product) {
            $result[] = $product->lang->title;
        }
        echo implode(' | ', $result);
        ?>
    </div>
</div>

<div class="form-group">
    <?= Html::label($model->getAttributeLabel('city_ids')) ?>
    <div class="input-group">

        <?php
        $result = [];
        foreach ($model->cities as $city) {
            $result[] = $city->getTitle();
        }
        echo implode(' | ', $result);
        ?>
    </div>
</div>

<div class="form-group">
    <?= Html::label($model->getAttributeLabel('amount')) ?>
    <div class="input-group">
        <?= $model->amount ?>
    </div>
</div>

<div class="row control-group">
    <div class="col-md-6">
        <?= $form->field($model, 'start_date_promotion')->datePicker($model->getStartDatePromotionTime()) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'end_date_promotion')->datePicker($model->getEndDatePromotionTime()) ?>
    </div>
</div>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(FactoryPromotion::statusRange()) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'payment_status')->dropDownList(FactoryPromotion::paymentStatusRange()) ?>
    </div>
</div>

