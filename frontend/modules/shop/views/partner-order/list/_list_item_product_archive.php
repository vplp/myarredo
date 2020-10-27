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
            Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
            ['target' => '_blank']
        ); ?>
    </div>
    <table class="char" width="100%">
        <tr>
            <td colspan="2">
                <?= Html::a(
                    $orderItem->product['lang']['title'],
                    Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                    ['class' => 'productlink']
                ); ?>
            </td>
        </tr>

        <?php if (!$orderItem->product['is_composition']) { ?>
            <tr>
                <td><span class="for-ordertable"><?= Yii::t('app', 'Артикул') ?></span></td>
                <td>
                <span class="for-ordertable-descr">
                    <?= $orderItem->product['article'] ?>
                </span>
                </td>
            </tr>
        <?php } ?>

        <tr class="noborder">
            <td colspan="2" class="spec-pad">
                <span class="for-ordertable"><?= Yii::t('app', 'Factory') ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="spec-pad2">
                <span class="for-ordertable-descr"><?= $orderItem->product['factory']['title'] ?></span>
            </td>
        </tr>
        <tr class="noborder">
            <td colspan="2"><span class="for-ordertable"><?= Yii::t('app', 'Цена для клиента') ?></span></td>
        </tr>
        <tr>
            <td colspan="2">
                <?= $orderItem->orderItemPrice['out_of_production'] == '1' ? Yii::t('app', 'Снят с производства') : $orderItem->orderItemPrice['price'] ?>
            </td>
        </tr>
    </table>
</div>
