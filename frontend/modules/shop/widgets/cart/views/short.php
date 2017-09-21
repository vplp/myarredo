<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\shop\models\Cart $cart
 */

$ids = [];
foreach ($items as $item) {
    $ids[] = $item['product_id'];
}

?>

<a href="<?= Url::toRoute(['/shop/cart/index']) ?>?mebel=<?= implode(';', $ids) ?>" class="my-notebook">
    <span class="red-but">
        <i class="glyphicon glyphicon-book"></i>
    </span>
    <span class="inscription">Мой блокнот: <?= $cart['items_total_count'] ?></span>
</a>