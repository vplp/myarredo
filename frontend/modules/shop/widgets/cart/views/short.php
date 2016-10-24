<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

?>

<div class="">
    <a href="<?= Url::toRoute(['/shop/cart/index']) ?>">
        <div class="">
            <span class="" "><?= Yii::t('app', 'Cart') ?></span>
            <div class="empty_bascket" style="display: <?= (int)$cart['items_total_count'] ? 'none' : 'block'; ?>">
                <span class=""><?= Yii::t('app', 'Добавьте товары') ?></span>
            </div>
            <div class="full_bascket" style="display: <?= (int)$cart['items_total_count'] ? 'block' : 'none'; ?>">
                <span class=""><span class=""><?= $cart['items_total_count'] ?></span> <?= Yii::t('app',
                        'items for summ price') ?>:</span>
                <span class=""><span class=""><?= $cart['items_total_summ'] ?></span></span>
            </div>
        </div>
    </a>
</div>

<!--для адаптивки
-->
<div class="product-in-basket">
    <?= Html::a(Yii::t('app', 'In cart') . ' ' . $cart['items_total_count'] . ' ' . Yii::t('app', 'items')); ?>
</div>