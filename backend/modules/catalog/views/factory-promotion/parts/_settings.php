<?php

use yii\helpers\Html;
use backend\modules\location\models\{
    Country, City
};

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