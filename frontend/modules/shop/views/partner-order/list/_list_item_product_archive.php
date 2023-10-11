<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $orderItem \frontend\modules\shop\models\OrderItem */
$user = Yii::$app->user->identity;
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
                    $orderItem->product->getTitle(),
                    Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                    ['class' => 'productlink']
                ); ?>
            </td>
        </tr>

        <?php if (isset($orderItem->product['is_composition']) && !$orderItem->product['is_composition']) { ?>
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
                <span class="for-ordertable-descr"><?= $orderItem->product['factory']['title'] ?? '' ?></span>
            </td>
        </tr>
        <tr class="noborder">
            <td colspan="2">
                <span class="for-ordertable"><?= Yii::t('app', 'Цена для клиента') ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?= $orderItem->orderItemPrice['out_of_production'] == '1'
                    ? Yii::t('app', 'Снят с производства')
                    : ($orderItem->orderItemPrice['price'] . ' ' . $orderItem->orderItemPrice['currency']) ?>
            </td>
        </tr>
    </table>
    <?php if (!Yii::$app->getUser()->isGuest && $user->profile->isPdfAccess()) { ?>
        <div class="downloads">
            <?php
            $pricesFiles = [];
            if (isset($orderItem->product->factoryPricesFiles)) {
                $pricesFiles = $orderItem->product->factoryPricesFiles;
            } else if (isset($orderItem->product->factory->pricesFiles)) {
                $pricesFiles = $orderItem->product->factory->pricesFiles;
            }

            ?>
            <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
            <ul>
                <?php
                    if (!empty($pricesFiles)) {
                        foreach ($pricesFiles as $priceFile) {
                            if ($fileLink = $priceFile->getFileLink()) { ?>
                                <li>
                                    <?= Html::a(
                                        $priceFile->title,
                                        Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $orderItem->product->article,
                                        [
                                            'target' => '_blank',
                                            'class' => 'click-on-factory-file',
                                            'data-id' => $priceFile->id
                                        ]
                                    ) ?>
                                </li>
                            <?php }
                        }
                    } else { ?>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Прайс листы') . ' <i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                                ['/catalog/factory/view-tab', 'alias' => $orderItem->product->factory->alias, 'tab' => 'pricelists'],
                                [
                                    'target' => '_blank',
                                    'class' => 'btn-inpdf'
                                ]
                            ) ?>
                        </li>
                    <?php } ?>

            </ul>

        </div>
    <?php } ?>
</div>
