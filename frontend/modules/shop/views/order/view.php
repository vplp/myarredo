<?php
use yii\helpers\{
    Html, Url
};

?>
<br>
<br>
<br>
<br>
<table border="2">
    <tr>
        <th><?=Yii::t('app', 'id') ?></th>
        <th><?= Yii::t('shop', 'Count of items') ?></th>
        <th><?= Yii::t('shop', 'Finish Summ') ?></th>
        <th><?= Yii::t('shop', 'Delivery price') ?></th>
        <th><?= Yii::t('shop', 'Order status') ?></th>
        <th><?= Yii::t('shop', 'Payd status') ?></th>
        <th><?= Yii::t('shop', 'Comment') ?></th>
    </tr>
        <tr>
            <td>
                <?= Html::a($order->id, Url::to(['/shop/order/view', 'id' =>$order->id])) ?>
            </td>
            <td>
                <?= $order['items_total_count'] ?>
            </td>
            <td>
                <?= $order['total_summ'] ?>
            </td>
            <td>
                <?= $order['delivery_price'] ?>
            </td>
            <td>
                <?= $order->getOrderStatus();?>
            </td>
            <td>
                <?= $order->getPaydStatus(); ?>
            </td>
            <td>
                <?= $order['comment'] ?>
            </td>
        </tr>
</table>
