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
           
            <div class="full_bascket">
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