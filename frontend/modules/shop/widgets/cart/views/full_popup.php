<?php

use yii\helpers\{
    Html, Url
};

?>

<div class="modal-dialog" role="document">
    <div class="modal-content cart-modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
        </div>
        <p>Предмет добавлен в блокнот</p>
        <div class="modal-body">
            <p> Предмет добавлен в мои желания </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" data-dismiss="modal">Продолжить покупки</button>
            <?= Html::a('Перейти в блокнот', ['/shop/cart/notepad'], ['class' => 'btn btn-goods']) ?>
        </div>
    </div>
</div>