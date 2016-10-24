<?php

use yii\helpers\{
    Html, Url
};

/**
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 */

?>

<div class="">
    <a href="<?= Url::toRoute(['/shop/cart/index']) ?>">
        <div class="">
            <?= Yii::t('app', 'Cart') ?>
            <div class="empty_bascket" style="display: <?= $cart['items_total_count'] ? 'none' : 'block'; ?>">
                <span class=""><?= Yii::t('app', 'Add tovar') ?></span>
            </div>
            <div class="full_bascket" style="display: <?= $cart['items_total_count'] ? 'block' : 'none'; ?>">
                <?= $cart['items_total_count'] ?><?= Yii::t('app', 'items for summ price') ?>:
                <?= $cart['items_total_summ'] ?>
            </div>
        </div>
    </a>
</div>

<!--для адаптивки
-->
<div class="product-in-basket">
    <?= Html::a(Yii::t('app', 'In cart') . ' ' . $cart['items_total_count'] . ' ' . Yii::t('app', 'items')); ?>
</div>