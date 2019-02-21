<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $product \frontend\modules\catalog\models\Product */
/* @var $item \frontend\modules\shop\models\CartItem */

?>

<?php if (!empty($product)) { ?>
    <div class="basket-item-info">
        <div class="item">
            <a href="javascript:void(0);" class="remove"
               onclick="delete_from_cart(<?= $item['product_id'] ?>, <?= $item['count'] ?>)">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="img-cont">
                <?= Html::a(
                    Html::img($product::getImageThumb($product['image_link'])),
                    $product::getUrl($product['alias'])
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
            <button type="button" class="btn btn-default read-more">
                <?= Yii::t('app', 'Подробнее') ?>
            </button>
        </div>
        <div class="more">
            <h4>
                <?= Yii::t('app', 'Description') ?>
            </h4>
            <p>
                <?= $product['lang']['description'] ?>
            </p>
        </div>
    </div>

<?php } ?>
