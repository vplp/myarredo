<?php

use yii\helpers\Html;

/**
 * @var \backend\modules\catalog\models\FactoryPromotion $model
 * @var \backend\app\bootstrap\ActiveForm $form
 */
?>

<div class="form-group">
    <?= Html::label($model->getAttributeLabel('product_ids')) ?>
    <div class="input-group">
        <?php
        $result = [];
        foreach ($model->products as $product) {
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
            $result[] = $city->lang->title;
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
<div class="form-group">
    <?= Html::label($model->getAttributeLabel('start_date_promotion')) ?>
    <div class="input-group">
        <?= $model->payment_status == 'paid'
            ? date('j.m.Y H:i', $model->start_date_promotion)
            : '-'; ?>
    </div>
</div>
<div class="form-group">
    <?= Html::label($model->getAttributeLabel('end_date_promotion')) ?>
    <div class="input-group">
        <?= $model->payment_status == 'paid'
            ? date('j.m.Y H:i', $model->end_date_promotion)
            : '-'; ?>
    </div>
</div>
<div class="form-group">
    <?= Html::label($model->getAttributeLabel('payment_status')) ?>
    <div class="input-group">
        <?= $model->getPaymentStatusTitle() ?>
    </div>
</div>
<div class="form-group">
    <?= Html::label($model->getAttributeLabel('status')) ?>
    <div class="input-group">
        <?= $model->getStatusTitle() ?>
    </div>
</div>
