<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product \frontend\modules\catalog\models\Product */
/* @var $item \frontend\modules\shop\models\CartItem */

?>

<?php if (!empty($product)) { ?>
    <div class="basket-item-info">
        <div class="item">
            <?= Html::a(
                '<i class="fa fa-times" aria-hidden="true"></i>',
                'javascript:void(0);',
                [
                    'class' => 'remove',
                    'onclick' => 'delete_from_cart(' . $item['product_id'] . ', ' . $item['count'] . ')'
                ]
            ) ?>
            <div class="img-cont">
                <?= Html::a(
                    Html::img($product::getImageThumb($product['image_link'])),
                    $product::getUrl($product[Yii::$app->languages->getDomainAlias()])
                ) ?>
            </div>
            <table width="100%">
                <tr>
                    <td><?= Yii::t('app', 'Предмет') ?></td>
                    <td><?= $product['lang']['title'] ?></td>
                </tr>
                <tr>
                    <td><?= Yii::t('app', 'Factory') ?></td>
                    <td><?= $product['factory']['title'] ?></td>
                </tr>
            </table>
            <?= Html::a(
                Yii::t('app', 'Подробнее'),
                $product::getUrl($product[Yii::$app->languages->getDomainAlias()]),
                ['class' => 'btn btn-default']
            ) ?>
        </div>
    </div>

<?php } ?>
