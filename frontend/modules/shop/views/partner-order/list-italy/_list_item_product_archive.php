<?php

use yii\helpers\{
    Html, Url
};

//
use frontend\modules\shop\models\OrderItem;
use frontend\modules\catalog\models\ItalianProduct;

/* @var $this yii\web\View */
/* @var $orderItem OrderItem */

?>

<div class="basket-item-info">

    <div class="img-cont">
        <?php if (ItalianProduct::isPublished($orderItem->product['alias'])) {
            echo Html::a(
                Html::img(ItalianProduct::getImageThumb($orderItem->product['image_link'])),
                ItalianProduct::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                ['target' => '_blank']
            );
        } else {
            echo Html::img(ItalianProduct::getImageThumb($orderItem->product['image_link']));
        } ?>
    </div>
    <table class="char" width="100%">
        <tr>
            <td colspan="2">
                <?php if (ItalianProduct::isPublished($orderItem->product['alias'])) {
                    Html::a(
                        $orderItem->product['lang']['title'],
                        ItalianProduct::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                        ['class' => 'productlink']
                    );
                } else {
                    echo $orderItem->product['lang']['title'];
                } ?>
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
        <tr class="noborder">
            <td colspan="2" class="spec-pad">
                <span class="for-ordertable"><?= Yii::t('app', 'Factory') ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="spec-pad2">
                <span class="for-ordertable-descr"><?= $orderItem->product['factory']['title'] ?? '' ?></span>
            </td>
        </tr>
        <tr class="noborder">
            <td colspan="2" class="spec-pad">
                <span class="for-ordertable"><?= Yii::t('app', 'Region') ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="spec-pad2">
                <span class="for-ordertable-descr"><?= $orderItem->product['region']['title'] ?? '' ?></span>
            </td>
        </tr>
        <tr class="noborder">
            <td colspan="2">
                <span class="for-ordertable"><?= Yii::t('app', 'Цена доставки') ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?= $orderItem->orderItemPrice['out_of_production'] == '1'
                    ? Yii::t('app', 'Снят с производства')
                    : $orderItem->orderItemPrice['price'] . ' ' . $orderItem->orderItemPrice['currency'] ?>
            </td>
        </tr>
    </table>
</div>
