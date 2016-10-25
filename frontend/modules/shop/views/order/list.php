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
        <th><?= Yii::t('app', 'count') ?></th>
        <th><?= Yii::t('app', 'price') ?></th>
        <th><?= Yii::t('app', 'delivery_price') ?></th>
        <th><?= Yii::t('app', 'order_status') ?></th>
        <th><?= Yii::t('app', 'payd_status') ?></th>
    </tr>
    <?php foreach ($orders as $order) : ?>
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
                <?= $order['order_status'] ?>
            </td>
            <td>
                <?= $order['payd_status'] ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

