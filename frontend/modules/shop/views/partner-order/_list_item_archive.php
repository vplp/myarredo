<?php

use yii\helpers\{
    Html, Url
};

/* @var $this yii\web\View */
/* @var $model \frontend\modules\shop\models\Order */

?>

    <div class="hidden-order-in">
        <div class="flex-product">

            <?php
            foreach ($model->items as $orderItem) {
                echo $this->render('_list_item_product_archive', [
                    'orderItem' => $orderItem,
                ]);
            } ?>

        </div>
        <div class="form-wrap">

        </div>
    </div>
