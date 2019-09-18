<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\shop\models\Order;

/* @var $this yii\web\View */
/* @var $modelOrder Order */

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
            <?php foreach ($modelOrder->orderAnswers as $key => $answer) {
                echo '<div><strong>' . $answer['user']['profile']['lang']['name_company'] . '</strong></div>';

                if (in_array(substr($modelOrder->lang, 0, 2), ['en', 'it'])) {
                    echo '<div>' . $answer['user']['email'] . '</div>' .
                        '<div>' . $answer['user']['profile']['phone'] . '</div>';
                }

                echo '<div>' . ($key + 1) . ') ' . $answer->getAnswerTime() . '</div>';
            } ?>
        </div>
    </div>
</div>
