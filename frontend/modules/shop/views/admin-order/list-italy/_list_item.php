<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\shop\models\{
    Order, OrderItem
};
use frontend\modules\catalog\models\ItalianProduct;

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $orderItem OrderItem */

?>

<div class="hidden-order-in">
    <div class="flex-product">

        <?php foreach ($modelOrder->items as $orderItem) { ?>
            <div class="basket-item-info">
                <div class="img-cont">
                    <?php if (ItalianProduct::isPublished($orderItem->product['alias'])) {
                        echo Html::a(
                            Html::img(ItalianProduct::getImageThumb($orderItem->product['image_link'])),
                            ItalianProduct::getUrl($orderItem->product['alias'])
                        );
                    } else {
                        echo Html::img(ItalianProduct::getImageThumb($orderItem->product['image_link']));
                    } ?>
                </div>
                <table class="char" width="100%">
                    <tr>
                        <td><?= Yii::t('app', 'Предмет') ?></td>
                        <td>
                            <?php if (ItalianProduct::isPublished($orderItem->product['alias'])) {
                                Html::a(
                                    $orderItem->product['lang']['title'],
                                    ItalianProduct::getUrl($orderItem->product['alias']),
                                    ['class' => 'productlink']
                                );
                            } else {
                                echo $orderItem->product['lang']['title'];
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Артикул') ?></td>
                        <td>
                            <?= $orderItem->product['article'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Factory') ?></td>
                        <td><?= $orderItem->product['factory']['title'] ?></td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Region') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $orderItem->product['region']['title'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Цена доставки') ?></td>
                        <td>
                            <?php
                            foreach ($orderItem->orderItemPrices as $price) {
                                echo '<div><strong>' . $price['user']['profile']['name_company'] . '</strong></div>' .
                                    '<div>' . $price['user']['email'] . '</div>' .
                                    '<div><strong>' . $price['price'] . '</strong></div><br>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>

                <div class="downloads">

                    <?php if (!empty($orderItem->product['factoryPricesFiles'])) { ?>
                        <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
                        <ul>
                            <?php
                            foreach ($orderItem->product['factoryPricesFiles'] as $priceFile) {
                                if ($fileLink = $priceFile->getFileLink()) { ?>
                                    <li>
                                        <?= Html::a($priceFile->title, $fileLink, ['target' => '_blank']) ?>
                                    </li>
                                <?php }
                            }
                            ?>
                        </ul>
                    <?php } ?>

                </div>

            </div>
        <?php } ?>

    </div>
    <div class="form-wrap">

        <div class="form-group">
            <?php
            echo Html::label($modelOrder->getAttributeLabel('comment')) .
                Html::textarea(
                    null,
                    $modelOrder->comment,
                    [
                        'class' => 'form-control',
                        'rows' => 5,
                        'disabled' => true
                    ]
                );

            foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' . $answer['user']['profile']['name_company'] . '</strong></div>' .
                    '<div>' . $answer['user']['email'] . '</div>' .
                    '<div>' . $answer->getAnswerTime() . '</div>' .
                    '<div>' . $answer['answer'] . '</div><br>';
            } ?>
        </div>

    </div>
</div>
