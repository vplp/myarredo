<?php

use yii\helpers\Url;

/**
 * @author Alla Kuzmenko
 * @copyright (c) 2016, Thread
 */

?>

<a href="<?= Url::toRoute(['/shop/cart/index']) ?>">
    <?= Yii::t('app', 'Корзина') ?>
    <?= $cart['items_total_count'] ?>
    <?= $cart['items_total_summ'] ?>   
</a>