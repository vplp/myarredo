<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $modelOrder \frontend\modules\shop\models\Order */
/* @var $orderItem \frontend\modules\shop\models\OrderItem */

?>

<div class="hidden-order-in">
    <div class="flex-product">

        <?php foreach ($modelOrder->items as $orderItem) { ?>
            <div class="basket-item-info">

                <div class="img-cont">
                    <?= Html::a(
                        Html::img(Product::getImageThumb($orderItem->product['image_link'])),
                        Product::getUrl($orderItem->product['alias'])
                    ); ?>
                </div>
                <table class="char" width="100%">
                    <tr>
                        <td>Предмет</td>
                        <td>
                            <?= Html::a(
                                $orderItem->product['lang']['title'],
                                Product::getUrl($orderItem->product['alias'])
                            ); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Артикул</td>
                        <td>
                            <?= $orderItem->product['article'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Фабрика</td>
                        <td><?= $orderItem->product['factory']['title'] ?></td>
                    </tr>
                    <tr>
                        <td>ЦЕНА для клиента</td>
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

                    <?php if (!empty($orderItem->product['factoryPricesFiles'])): ?>
                        <p class="title-small">Посмотреть прайс листы</p>
                        <ul>
                            <?php foreach ($orderItem->product['factoryPricesFiles'] as $priceFile): ?>
                                <?php if ($fileLink = $priceFile->getFileLink()): ?>
                                    <li>
                                        <?= Html::a($priceFile->title, $fileLink, ['target' => '_blank']) ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

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
                    $modelOrder->comment, [
                    'class' => 'form-control',
                    'rows' => 5,
                    'disabled' => true
                ]);
            ?>

            <?php foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' . $answer['user']['profile']['name_company'] . '</strong></div>' .
                    '<div>' . $answer['user']['email'] . '</div>' .
                    '<div>' . $answer->getAnswerTime() . '</div>' .
                    '<div>' . $answer['answer'] . '</div><br>';
            } ?>

        </div>

    </div>
</div>
