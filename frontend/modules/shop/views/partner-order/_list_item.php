<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\shop\models\CartItem */

?>

<div class="basket-item-info">
    <div class="item">
        <div class="img-cont">
            <?= Html::a(Html::img(Product::getImageThumb($item->product->image_link))); ?>
        </div>
        <table width="100%">
            <tr>
                <td>Предмет</td>
                <td><?= $item->product['lang']['title'] ?></td>
            </tr>
            <tr>
                <td>
                    Артикул
                </td>
                <td>
                    <?= $item->product['article'] ?>
                </td>
            </tr>
            <tr>
                <td>Фабрика</td>
                <td><?= $item->product['factory']['lang']['title'] ?></td>
            </tr>
        </table>
    </div>
</div>