<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $modelOrder \frontend\modules\shop\models\Order */
/* @var $modelOrderAnswer \frontend\modules\shop\models\OrderAnswer */
/* @var $orderItem \frontend\modules\shop\models\OrderItem */

if (Yii::$app->user->identity->profile->possibilityToAnswer) { ?>

    <?php $form = ActiveForm::begin([
        //'method' => 'post',
        'id' => 'OrderAnswerForm',
        'options' => ['data' => ['pjax' => true]],
        'action' => $modelOrder->getPartnerOrderOnListUrl(),
    ]); ?>

    <div class="hidden-order-in">
        <div class="flex-product">

            <?php
            foreach ($modelOrder->items as $orderItem) { ?>

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
                                <?= $form
                                    ->field($orderItem->orderItemPrice, 'price')
                                    ->input('text', [
                                        'name' => 'OrderItemPrice[' . $orderItem->product_id . ']',
                                        'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true
                                    ])
                                    ->label(false);
                                ?>
                            </td>
                        </tr>
                    </table>

                    <?php if (
                        !Yii::$app->getUser()->isGuest &&
                        Yii::$app->user->identity->profile->isPdfAccess()
                    ): ?>

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

                    <?php endif; ?>

                </div>

            <?php } ?>

        </div>
        <div class="form-wrap">

            <?= $form->field($modelOrder, 'comment')
                ->textarea(['rows' => 5, 'disabled' => true]) ?>

            <?= $form
                ->field($modelOrderAnswer, 'answer')
                ->textarea(['rows' => 5, 'disabled' => (!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0) ? false : true]) ?>

            <?= $form
                ->field($modelOrderAnswer, 'id')
                ->input('hidden')
                ->label(false) ?>

            <?= $form
                ->field($modelOrderAnswer, 'order_id')
                ->input('hidden', ['value' => $modelOrder->id])
                ->label(false) ?>

        </div>
    </div>

    <?php if (!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0) {
        echo Html::submitButton('Сохранить', [
            'class' => 'btn btn-success action-save-answer',
            'name' => 'action-save-answer',
            'value' => 1
        ]);
    } ?>

    <?php if ($modelOrderAnswer->id && $modelOrderAnswer->answer_time == 0) {
        echo Html::submitButton('Отправить ответ клиенту', [
            'class' => 'btn btn-success',
            'name' => 'action-send-answer',
            'value' => 1
        ]);
    } ?>

    <?php ActiveForm::end(); ?>

<?php } else { ?>

    <div class="hidden-order-in">
        <div class="flex-product">

            <?php
            foreach ($modelOrder->items as $orderItem) {
                echo $this->render('_list_item_product_archive', [
                    'orderItem' => $orderItem,
                ]);
            } ?>

        </div>
        <div class="form-wrap">

        </div>
    </div>

<?php } ?>

