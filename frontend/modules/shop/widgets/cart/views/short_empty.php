<?php

use yii\helpers\Url;

/**
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 */

?>

<div class="">
    <a href="<?= Url::toRoute(['/shop/cart/index']) ?>">
        <div class="">
            <?= Yii::t('app', 'Cart') ?>
            <div class="empty_bascket">
                <span class=""><?= Yii::t('app', 'Add tovar') ?></span>
            </div>         
        </div>
    </a>
</div>

<!--для адаптивки
-->
<div class="product-in-basket">
    <span class=""><?= Yii::t('app', 'Add tovar') ?></span>
</div>