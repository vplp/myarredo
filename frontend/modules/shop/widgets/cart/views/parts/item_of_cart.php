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
            <button type="button" class="btn btn-default read-more">
                Подробнее
            </button>
        </div>
        <div class="more">
            <h4>
                Описание
            </h4>
            <p>
                <?= $product['lang']['description'] ?>
            </p>
            <div class="form-group">
                <h4>Комментарии</h4>
                <textarea class="form-control"></textarea>
            </div>
        </div>
    </div>

    <!--
    <tr>
        <td class="img-cont"><?= Html::img($product->getImageLink()) ?></td>
        <td class="prod-name">
            <?= $product['lang']['title']; ?>
            <div class="price">
                <div class="mobile td-name">Цена: </div>
                <div class="value"><?= $item['price'] ?>&nbsp;<span>грн</span></div>
            </div>
        </td>
        <td class="quantity">
            <div class="mobile td-name">Количество: </div>
            <input type="number"
                   min="1"
                   value="<?= $item['count'] ?>"
                   onchange="change_count_cart_item(<?= $product['id'] ?> , this.value, <?= $item['count'] ?>)"
            >
        </td>
        <td class="sum-price">
            <div class="mobile td-name">Сумма: </div>
            <div class="value"><?= $item['total_summ'] ?>&nbsp;<span>грн</span>
            </div>
        </td>
        <td class="delete-cont">
            <a href="javascript:void(0);" class="delete" onclick="delete_from_cart(<?= $item['product_id'] ?>, <?= $item['count'] ?>)"></a>
        </td>
    </tr>
    -->
<?php endif; ?>

