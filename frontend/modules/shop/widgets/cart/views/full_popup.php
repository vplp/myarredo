<?php

use yii\helpers\{
    Html, Url
};

?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Добавление предмета в блокнот</h4>
        </div>
        <p>Предмет добавлен в блокнот</p>
        <!--<div class="modal-body">
            <?php foreach ($items as $item): ?>
                <?= $this->render('parts/item_of_cart_popup', ['item' => $item, 'product' => $products[$item['product_id']] ?? []]); ?>
            <?php endforeach; ?>
        </div>-->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
            <?= Html::a('Перейти в блокнот', ['/shop/cart/notepad'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>