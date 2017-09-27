<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\CartItem */

?>

<?php if (!empty($product)) : ?>

    <div class="basket-item-info">
        <div class="item">
            <a href="javascript:void(0);" class="remove" onclick="delete_from_cart(<?= $item['product_id'] ?>, <?= $item['count'] ?>)">
                <i class="fa fa-times" aria-hidden="true"></i>
            </a>
            <div class="img-cont">
                <?= Html::a(Html::img($product->getImage()), Product::getUrl($product['alias'])) ?>
            </div>
            <table width="100%">
                <tr>
                    <td>Предмет</td>
                    <td><?= $product['lang']['title'] ?></td>
                </tr>
                <tr>
                    <td>Фабрика</td>
                    <td><?= $product['factory']['lang']['title'] ?></td>
                </tr>
            </table>
            <button type="button" class="btn btn-default read-more">Подробнее</button>
        </div>
        <div class="more">
            <h4>
                Описание
            </h4>
            <p>
                <?= $product['lang']['description'] ?>
            </p>
        </div>
    </div>

<?php endif; ?>

