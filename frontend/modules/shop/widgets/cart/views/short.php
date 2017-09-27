<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\shop\models\Cart $cart
 */

?>

<a href="<?= Url::toRoute(['/shop/cart/index']) ?>" class="my-notebook">
    <span class="red-but">
        <i class="glyphicon glyphicon-book"></i>
    </span>
    <span class="inscription">Мой блокнот: <?= $cart['items_count'] ?></span>
</a>