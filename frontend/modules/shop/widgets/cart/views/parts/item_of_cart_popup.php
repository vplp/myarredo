<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $item \frontend\modules\catalog\models\Product */
/* @var $product \frontend\modules\shop\models\CartItem */

?>

<?php if (!empty($product)) { ?>
    <tr>
        <td class="img-td">
            <div class="img-cont"><?= Html::img($product->getImage()) ?></div>
        </td>
        <td>
            <div class="name"><?= $product['lang']['title']; ?></div>
            <div class="price"><?= $item['price'] ?>&nbsp;<span>грн</span></div>
        </td>
        <td class="quan-td">
            <input type="number"
                   data-styler
                   min="1"
                   value="<?= $item['count'] ?>"
                   readonly
                   onchange="change_count_cart_popup_item(<?= $product['id'] ?> , this.value, <?= $item['count'] ?>)"
            >

        </td>
        <td class="price-td">
            <div class="price"><?= $item['total_summ'] ?>&nbsp;<span>грн</span></div>
        </td>
        <td class="remove-td">
            <?= Html::a(
                '',
                'javascript:void(0);',
                [
                    'class' => 'remove',
                    'onclick' => 'delete_from_popup(' . $item['product_id'] . ', ' . $item['count'] . ')'
                ]
            ) ?>
        </td>
    </tr>

<?php }
