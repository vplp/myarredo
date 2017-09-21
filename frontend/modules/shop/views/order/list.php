<?php

use frontend\themes\defaults\assets\AppAsset;
//
use yii\helpers\{
    Html, Url
};

$bundle = AppAsset::register($this);

/**
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */

?>

<div class="table-orders">
    <?php if (!empty($orders)): ?>
        <table>
            <tr class="name-colums">
                <td>№ заказа</td>
                <td>дата</td>
                <td>сумма</td>
                <td>статус</td>
                <td colspan="1"><span>посмотреть</td>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="number-order"><?= Html::a($order->id, Url::to(['/shop/order/view', 'id' =>$order->id])) ?></td>
                    <td class="data-order"><?= $order->getCreatedTime()?></td>
                    <td class="sum-order"><span><?= $order['total_summ'] ?></span>грн</td>

                    <td class="status-order"><?= $order['order_status'] ?></td>
                    <td class="picture-order">
                        <?= Html::a(Html::img($bundle->baseUrl . '/images/icons/view.png'), Url::to(['/shop/order/view', 'id' =>$order->id])) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>