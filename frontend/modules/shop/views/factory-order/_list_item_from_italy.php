<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\shop\models\{
    Order, OrderItem, OrderAnswer
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $modelOrderAnswer OrderAnswer */
/* @var $orderItem OrderItem */

?>

<?php $form = ActiveForm::begin([
    'id' => 'OrderAnswerForm',
    'options' => ['data' => ['pjax' => true]],
    'action' => Url::toRoute(['/shop/factory-order/list-from-italy']) . '#' . $modelOrder->id,
]); ?>

    <div class="hidden-order-in ordersanswer-box">
        <div class="flex-product orderanswer-cont">

            <?php
            foreach ($modelOrder->items as $orderItem) { ?>
                <div class="basket-item-info">

                    <div class="img-cont">
                        <?= Html::a(
                            Html::img(Product::getImageThumb($orderItem->product['image_link'])),
                            Product::getUrl($orderItem->product['alias']),
                            ['target' => '_blank']
                        ); ?>
                    </div>
                    <table class="char" width="100%">
                        <tr>
                            <td colspan="2">
                                <?= Html::a(
                                    $orderItem->product['lang']['title'],
                                    Product::getUrl($orderItem->product['alias']),
                                    ['class' => 'productlink']
                                ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Артикул') ?>
                                </span>
                            </td>
                            <td>
                                <?= $orderItem->product['article'] ?>
                            </td>
                        </tr>
                        <tr class="noborder">
                            <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Factory') ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="spec-pad2">
                                <?= $orderItem->product['factory']['title'] ?>
                            </td>
                        </tr>
                        <tr class="noborder">
                            <td colspan="2" class="spec-pad">
                            <span class="for-ordertable">
                                <?= Yii::t('app', 'Цена для клиента') ?>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
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

                    <?php if (!Yii::$app->getUser()->isGuest &&
                        Yii::$app->user->identity->profile->isPdfAccess()) { ?>
                        <div class="downloads">

                            <?php
                            $pricesFiles = [];
                            if (isset($orderItem->product->factoryPricesFiles)) {
                                $pricesFiles = $orderItem->product->factoryPricesFiles;
                            } else if (isset($orderItem->product->factory->pricesFiles)) {
                                $pricesFiles = $orderItem->product->factory->pricesFiles;
                            }

                            if (!empty($pricesFiles)) { ?>
                                <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
                                <ul>
                                    <?php foreach ($pricesFiles as $priceFile) {
                                        if ($fileLink = $priceFile->getFileLink()) { ?>
                                            <li>
                                                <?= Html::a(
                                                    $priceFile->title,
                                                    $fileLink,
                                                    [
                                                        'target' => '_blank',
                                                        'class' => 'click-by-factory-file',
                                                        'data-id' => $priceFile->id
                                                    ]
                                                ) ?>
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>

            <?php } ?>

        </div>
        <div class="form-wrap">

            <?= $form->field($modelOrder, 'comment')
                ->textarea(['rows' => 5, 'disabled' => true]) ?>

            <?= $form
                ->field($modelOrderAnswer, 'answer')
                ->textarea([
                    'rows' => 5,
                    'disabled' => (!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0) ? false : true
                ]) ?>

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

<?php if (!$modelOrderAnswer->id) {
    echo Html::button(
        Yii::t('app', 'Отправить ответ клиенту'),
        [
            'class' => 'btn btn-success action-save-answer',
            'name' => 'action-save-answer',
            'value' => 1
        ]
    );
} ?>

<?php ActiveForm::end(); ?>