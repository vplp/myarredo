<?php

use yii\helpers\{
    Html, Url
};

/* @var $this yii\web\View */
/* @var $modelOrder \frontend\modules\shop\models\Order */

?>

<div class="hidden-order-in">
    <div class="flex-product">

        <?php
        foreach ($modelOrder->items as $orderItem) {
            echo $this->render('_list_item_product_archive', [
                'orderItem' => $orderItem,
            ]);
        } ?>

    </div>
    <div class="form-wrap">

        <div class="form-group">
            <?= Html::label('comment', null, ['class' => 'control-label']); ?>
            <?= Html::textarea(null, $modelOrder['comment'], [
                'class' => 'form-control',
                'disabled' => true
            ]); ?>
        </div>

        <div class="form-group">
            <?= Html::label('answer', null, ['class' => 'control-label']); ?>
            <?= Html::textarea(null, $modelOrder['answer'], [
                'class' => 'form-control',
                'disabled' => true
            ]); ?>
        </div>

    </div>
</div>
