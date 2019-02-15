<?php

use yii\helpers\{
    Html, Url
};

?>

<div class="flex s-between basket-items">
    <?php foreach ($items as $item): ?>
        <?= $this->render('parts/item_of_cart', ['item' => $item, 'product' => $products[$item['product_id']] ?? []]); ?>
    <?php endforeach; ?>
</div>

<?php if (count($items) > 3): ?>
    <button type="button" class="btn btn-default show-all">Показать все</button>
<?php endif; ?>

<!--
<div class="basket-cont">
    <div class="basket-cont-in">
        <div class="fix-table-header">
            <div>Фото</div>
            <div>Наименование товара и цена</div>
            <div>Количество</div>
            <div>Сумма</div>
            <div>Удалить</div>
        </div>
        <div class="basket-table">
            <table width="100%">

                <?php /*foreach ($items as $item): ?>
                    <?= $this->render('parts/item_of_cart', ['item' => $item, 'product' => $products[$item['product_id']] ?? []]); ?>
                <?php endforeach;*/ ?>

            </table>
        </div>
        <div class="result flex s-between c-align">
            <div>
                Сума к оплате:
            </div>
            <div>
                5751,00 <span>грн</span>
            </div>
        </div>
        <div class="control-buttons flex s-between">
            <div class="flex">
                <a href="#quick-order" data-fancybox class="std-but std-but-empty">
                    Быстрый заказ
                </a>
                <a href="javascript:void(0);" class="std-but std-but-empty">
                    Добавить в резерв
                </a>
            </div>

            <?= Html::a('Оформить заказ', ['/shop/cart/checkout'], ['class' => 'std-but']) ?>
        </div>
    </div>
</div>

-->
<?php
$script = <<< JS
    $('.basket-item-info').on('click', '.remove', function() {
        window.location.reload();
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>