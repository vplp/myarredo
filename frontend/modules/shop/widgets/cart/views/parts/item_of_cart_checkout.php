<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\CartItem */


if (!empty($product)) { ?>
    <tr>
        <td>
            <div class="prod-name"><?= $product['lang']['title']; ?></div>
        </td>
        <td class="td-quantity">
            <div class="mobile">
                Количество:
            </div>
            <div class="quantity"><?= $item['count'] ?></div>
        </td>
        <td class="td-price">
            <div class="mobile">
                Цена:
            </div>
            <div class="price"><?= $item['total_summ'] ?>&nbsp;<span>грн</span></div>
        </td>
    </tr>
    <?php
}
