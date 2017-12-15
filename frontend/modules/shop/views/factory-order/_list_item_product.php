<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $orderItem \frontend\modules\shop\models\OrderItem */

?>

<div class="basket-item-info">

    <div class="img-cont">
        <?= Html::a(
            Html::img(Product::getImageThumb($orderItem->product['image_link'])),
            Product::getUrl($orderItem->product['alias'])
        ); ?>
    </div>
    <table class="char" width="100%">
        <tr>
            <td>Предмет</td>
            <td>
                <?= Html::a(
                    $orderItem->product['lang']['title'],
                    Product::getUrl($orderItem->product['alias'])
                ); ?>
            </td>
        </tr>
        <tr>
            <td>Артикул</td>
            <td>
                <?= $orderItem->product['article'] ?>
            </td>
        </tr>
        <tr>
            <td>Фабрика</td>
            <td><?= $orderItem->product['factory']['lang']['title'] ?></td>
        </tr>
    </table>
</div>