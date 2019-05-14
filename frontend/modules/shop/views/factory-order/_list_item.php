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
            <div><?= Yii::t('app', 'Response time') ?>:</div>
            <?php
            foreach ($modelOrder->orderAnswers as $key => $answer) {
                echo '<div><strong>' . $answer['user']['profile']['lang']['name_company'] . '</strong></div>' .
                    '<div>' . ($key + 1) . ') ' . $answer->getAnswerTime() . '</div>';
            }
            ?>
        </div>

    </div>
</div>
