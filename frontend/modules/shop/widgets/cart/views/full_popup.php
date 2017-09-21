<?php

use yii\helpers\{
    Html, Url
};

?>

<div class="std-modal" id="add-basket">
    <div class="sticker">Мой блокнот</div>
    <div class="modal-body">
        <div class="table-cont">
            <table class="bask-table">
                <tr>
                    <th>Фото</th>
                    <th>Наименование товара и цена</th>
                    <th>Количество</th>
                    <th>Сумма</th>
                    <th>Удалить</th>
                </tr>

                <?php foreach ($items as $item): ?>
                    <?= $this->render('parts/item_of_cart_popup', ['item' => $item, 'product' => $products[$item['product_id']] ?? []]); ?>
                <?php endforeach; ?>

            </table>
        </div>

        <div class="sum flex s-between c-align">
            <div>Сумма к оплате:</div>
            <div class="sum-price"><?= $cart['items_total_summ'] ?>&nbsp;<span>грн</span></div>
        </div>

        <div class="bot-buttons flex s-between">
            <?= Html::a('Продолжить покупки', 'javascript:void(0);', ['class' => '', 'onclick' => '']) ?>
            <?= Html::a('Далее', ['/shop/cart/index'], ['class' => '']) ?>
        </div>

    </div>
</div>