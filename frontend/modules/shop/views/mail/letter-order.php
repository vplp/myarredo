<?php
/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
$articles = $cart->cartGoods;
?>
<div class="block-title">Заказ №<?= $cart['id'] ?></div>
<div class="order">
    <table class="table">
        <thead>
        <tr class="th">
            <th class="td">Фото</th>
            <th class="td"></th>
            <th class="td">Количество</th>
            <th class="td">Статус</th>
            <th class="td">Цена за единицу</th>
            <th class="td">Итого</th>
            <th class="td"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($articles as $article) :
            echo $this->render('orderitem', ['article' => $article, 'cart' => $cart]);
        endforeach;
        ?>
        </tbody>
    </table>
</div>
<div class="delivery" style="font-weight: bold; margin-top: 15px;">
    <span class="label">Доставка</span>
</div>
<table class="total-summ" style="margin-top: 15px;">
    <tr>
        <td class="label">Всего за товары</td>
        <td class="price-container">
            <span class="summ actual-price"><?= $cart['summ'] ?></span>
            <span class="currency">грн</span>
        </td>
    </tr>
    <tr>
        <td class="label">Доставка</td>
        <td class="price-container">
            <span class="summ actual-price">0</span>
            <span class="currency">грн</span>
        </td>
    </tr>
    <tr>
        <td class="label">Итого</td>
        <td class="price-container">
            <span class="summ actual-price"><?= $cart['total'] ?></span>
            <span class="currency">грн</span>
        </td>
    </tr>
</table>
<?= $this->render('customer-form', ['model' => $customerform]) ?>
