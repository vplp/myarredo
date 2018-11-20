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
            <td colspan="2">
                <?= Html::a(
                    $orderItem->product['lang']['title'],
                    Product::getUrl($orderItem->product['alias']),
                    ['class' => 'productlink']
                ); ?>
            </td>
        </tr>
        <tr>
            <td><span class="for-ordertable"><?= Yii::t('app', 'Артикул') ?></span></td>
            <td>
                <span class="for-ordertable-descr">
                <?= $orderItem->product['article'] ?>
                </span>
            </td>
        </tr>
        <tr>
            <td><span class="for-ordertable"><?= Yii::t('app', 'Factory') ?></span></td>
            <td><span class="for-ordertable-descr"><?= $orderItem->product['factory']['title'] ?></span></td>
        </tr>
        <tr>
            <td><span class="for-ordertable"><?= Yii::t('app', 'Цена для клиента') ?></span></td>
            <td>
                <?= $orderItem->orderItemPrice['price'] ?>
            </td>
        </tr>
    </table>
</div>