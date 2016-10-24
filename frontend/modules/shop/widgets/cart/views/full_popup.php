<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
?>

<div class="">
    <?= Yii::t('app', 'Cart') ?>
</div>
<div class="">
    <table border="2">
        <tr>
            <th><?= Yii::t('app', 'id') ?></th>
            <th><?= Yii::t('app', 'count') ?></th>
            <th><?= Yii::t('app', 'price') ?></th>
            <th><?= Yii::t('app', 'discount_full') ?></th>
            <th><?= Yii::t('app', 'total_summ') ?></th>
            <th><?= Yii::t('app', 'extra_param') ?></th>
        </tr>
        <?php
        foreach ($items as $item) {
            echo $this->render('parts/item_of_cart', ['item' => $item]);
        }
        ?>
    </table>
</div>
<div class="">
    <div class="">
        <span class=""><?= Yii::t('app', 'Summ for pay') ?>:</span>
        <span class="total-price"><?= $cart['items_total_summ'] ?></span>
    </div>
    <div class="">
        <?= Html::a(Yii::t('app', 'Checkout', Url::toRoute(['/shop/cart/index']))) ?>
    </div>
</div>

