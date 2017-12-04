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
            echo $this->render('_list_item_product', [
                'orderItem' => $orderItem,
            ]);
        } ?>

    </div>
    <div class="form-wrap">

        <div class="form-group">

            <?php
            echo Html::label($modelOrder->getAttributeLabel('comment')) .
                Html::textarea(
                    null,
                    $modelOrder->comment, [
                    'class' => 'form-control',
                    'rows' => 5,
                    'disabled' => true
                ]);
            ?>

            <?php
            foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' .
                    $answer['user']['profile']['name_company'] .
                    ' ' .
                    $answer['user']['email'] .
                    '</strong></div>' .
                    '<div>' .
                    $answer['answer'] .
                    '</div><br>';
            }
            ?>

        </div>

    </div>
</div>
