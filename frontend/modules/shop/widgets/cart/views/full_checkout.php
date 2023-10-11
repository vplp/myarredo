<?php

use yii\helpers\{
    Html, Url
};

?>

<div class="fix-table-header">
    <div>Наименование товара</div>
    <div>Количество</div>
    <div>Сумма</div>
</div>
<div class="order-table">
    <table width="100%">

        <?php foreach ($items as $item): ?>
            <?= $this->render('parts/item_of_cart_checkout', ['item' => $item, 'product' => $products[$item['product_id']] ?? []]); ?>
        <?php endforeach; ?>

    </table>
</div>

<div class="result flex s-between c-align">
    <div>
        Сума к оплате:
    </div>
    <div><?= $cart['items_total_summ'] ?>&nbsp;<span>грн</span></div>
</div>

