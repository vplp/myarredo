<?php

use yii\helpers\{
    Html, Url
};

/* @var $this yii\web\View */
/* @var $modelOrder \frontend\modules\shop\models\Order */

?>

<div class="hidden-order-in ordersanswer-box">

    <div class="form-wrap">

        <div class="form-group">
            <?= Html::label(
                $modelOrder->getAttributeLabel('comment'),
                null,
                ['class' => 'control-label']
            ) ?>
            <?= Html::textarea(null, $modelOrder['comment'], [
                'class' => 'form-control',
                'disabled' => true,
                'rows' => 5
            ]) ?>
        </div>
        <div class="form-group">
            <?= Html::label(
                $modelOrder->orderAnswer->getAttributeLabel('answer'),
                null,
                ['class' => 'control-label']
            ) ?>
            <?= Html::textarea(null, $modelOrder['orderAnswer']['answer'], [
                'class' => 'form-control',
                'disabled' => true,
                'rows' => 5
            ]) ?>
        </div>
    </div>

    <div class="flex-product orderanswer-cont">

        <?php
        foreach ($modelOrder->items as $orderItem) {
            echo $this->render('_list_item_product_archive', [
                'orderItem' => $orderItem,
            ]);
        } ?>

    </div>
</div>
