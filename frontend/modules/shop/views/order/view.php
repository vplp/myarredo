<?php
use yii\helpers\{
    Html, Url
};

?>

<div class="basket_items_w">
    <table class="basket_items">
        <thead>
        <tr>
            <th>Наименование товара</th>
            <th>Количество</th>
            <th>Сумма</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($order->items as $item): ?>
            <tr>
                <td class="item">
                    <?= Html::a($item->product['Name'], $item->product->getUrl(), ['class' => 'item_t']) ?>
                </td>
                <td class="count"><?= $item['count'] ?></td>
                <td class="quantity">
                    <div class="sum_basket"><?= $item['total_summ'] ?><span>грн</span></div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="basket_total cf">
    <div class="basket_total_l">
        <div class="basket_total_l_cnt">
            <div class="basket_total_t">Общая сумма к оплате:</div>
        </div>
    </div>
    <div class="basket_total_r">
        <div class="basket_total_price"><?= $order['total_summ'] ?><span>грн</span></div>
    </div>
</div>