<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
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
                            ItalianProduct::getUrl($orderItem->product['alias']),
                            ['target' => '_blank']
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
                                echo Html::a(
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
                        <td><?= $orderItem->product['article'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Factory') ?></td>
                        <td>
                            <?php if ($orderItem->product['factory']['title']) {
                                echo Html::a(
                                    $orderItem->product['factory']['title'],
                                    Factory::getUrl($orderItem->product['factory']['alias'])
                                );
                            } else {
                                echo $orderItem->product['factory_name'];
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Region') ?></td>
                        <td><?= $orderItem->product['region']['title'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td><?= Yii::t('app', 'Цена доставки') ?></td>
                        <td>
                            <?php
                            foreach ($orderItem->orderItemPrices as $price) {
                                echo '<div><strong>' . $price['user']['profile']['lang']['name_company'] . '</strong></div>' .
                                    '<div>' . $price['user']['email'] . '</div>' .
                                    '<div><strong>' . ($price['out_of_production'] == '1' ? Yii::t('app', 'Снят с производства') : $price['price']) . '</strong></div><br>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
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

            if ($modelOrder->lang != 'ru-RU') {
                $form = ActiveForm::begin([
                    'id' => 'OrderAnswerForm',
                    'options' => ['data' => ['pjax' => true]],
                    'action' => Url::toRoute(['/shop/admin-order/update', 'id' => $modelOrder->id]),
                ]);

                echo $form
                        ->field($modelOrder, 'admin_comment')
                        ->textarea(['rows' => 5])

                    . Html::submitButton(
                        Yii::t('app', 'Save'),
                        [
                            'class' => 'btn btn-success',
                            'name' => 'action-save-admin-comment',
                            'value' => 1
                        ]
                    );

                ActiveForm::end();
            }

            foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' . $answer['user']['profile']['lang']['name_company'] . '</strong></div>' .
                    '<div>' . $answer['user']['email'] . '</div>' .
                    '<div>' . $answer->getAnswerTime() . '</div>' .
                    '<div>' . $answer['answer'] . '</div><br>';
            } ?>
        </div>

    </div>
</div>
