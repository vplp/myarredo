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
            <?= Html::label($modelOrder->getAttributeLabel('comment'), null, ['class' => 'control-label']); ?>
            <?= Html::textarea(null, $modelOrder['comment'], [
                'class' => 'form-control',
                'disabled' => true,
                'rows' => 5
            ]); ?>
        </div>

        <div class="form-group">
            <?= Html::label($modelOrder->orderAnswer->getAttributeLabel('answer'), null, ['class' => 'control-label']); ?>
            <?= Html::textarea(null, $modelOrder['orderAnswer']['answer'], [
                'class' => 'form-control',
                'disabled' => true,
                'rows' => 5
            ]); ?>
        </div>
        <div class="form-group">
            <div><?= Yii::t('app', 'Response time') ?>:</div>
        <?php foreach ($modelOrder->orderAnswers as $key => $answer) {
            echo '<div>' . ($key+1) . ') '.$answer->getAnswerTime() . '</div>';
        } ?>
        </div>

    </div>
</div>
