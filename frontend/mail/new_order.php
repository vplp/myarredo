<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\CartItem */

?>

<div>
    <p>Для просмотра заказа пройдите по<a href="<?= $order->getTokenLink() ?>"> ссылке</a></p>
    <div>
        <p> <?= $order->customer['full_name']; ?></p>
        Телефон <?= $order->customer['phone'] ?> <br>
        Email: <?= $order->customer['email'] ?> <br>
    </div>
    <div>

        <?php foreach ($order->items as $item): ?>
            <p>
                <?= Html::a($item->product['lang']['title'], Product::getUrl($item->product['alias'])) ?>
            </p>
        <?php endforeach; ?>

    </div>

</div>