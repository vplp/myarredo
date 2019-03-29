<?php

use yii\helpers\{
    Html, Url
};

?>

<div class="modal-dialog modal-cart" role="document">
    <div class="modal-content cart-modal">
        <div class="modal-header">
            <?= Html::button(
                '<span aria-hidden="true">&times;</span>',
                ['class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']
            ) ?>
        </div>
        <div class="modal-body">
            <p><?= Yii::t('app', 'Предмет добавлен в мои желания') ?></p>
        </div>
        <div class="modal-footer">
            <?= Html::button(
                Yii::t('app', 'Продолжить покупки'),
                ['class' => 'btn btn-cancel', 'data-dismiss' => 'modal']
            ) ?>
            <?= Html::a(
                Yii::t('app', 'Перейти в блокнот'),
                ['/shop/cart/notepad'],
                ['class' => 'btn btn-goods']
            ) ?>
        </div>
    </div>
</div>