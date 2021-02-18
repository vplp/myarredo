<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\{
    Order, OrderItem, OrderAnswer
};
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $orderItem OrderItem */
/* @var $modelOrderAnswer OrderAnswer */

?>

<?php $form = ActiveForm::begin([
    'id' => 'OrderAnswerForm',
    'options' => ['data' => ['pjax' => true]],
    'action' => Yii::$app->request->url . '?' . $modelOrder->id,
]); ?>

<div class="hidden-order-in">
    <div class="flex-product">

        <?php foreach ($modelOrder->items as $orderItem) { ?>
            <div class="basket-item-info">

                <div class="img-cont">
                    <?= Html::a(
                        Html::img(Product::getImageThumb($orderItem->product['image_link'])),
                        Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                        ['target' => '_blank']
                    ); ?>
                </div>
                <table class="char" width="100%">
                    <tr>
                        <td><?= Yii::t('app', 'Subject') ?></td>
                        <td>
                            <?= Html::a(
                                $orderItem->product['lang']['title'],
                                Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()])
                            ); ?>
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
                        <td><?= $orderItem->product['factory']['title'] ?? '' ?></td>
                    </tr>

                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                            <span class="for-ordertable">
                                <?= Yii::t('app', 'Цена для клиента') ?>
                            </span>
                        </td>
                    </tr>
                    <tr class="orderlist-price-tr">
                        <td colspan="2">
                            <?= $form
                                ->field($orderItem->orderItemPrice, 'product_id')
                                ->input('hidden', [
                                    'name' => 'OrderItemPrice[' . $orderItem->product_id . '][product_id]',
                                    'class' => 'order-productid-hfield'
                                ])
                                ->label(false);
                            ?>
                            <?= $form
                                ->field($orderItem->orderItemPrice, 'price')
                                ->input('text', [
                                    'name' => 'OrderItemPrice[' . $orderItem->product_id . '][price]',
                                    'value' => $orderItem->orderItemPrice->price ?? 0,
                                    'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true,
                                    'class' => 'orderlist-price-field'
                                ])
                                ->label(false);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="order-list-td">
                            <?= $form
                                ->field($orderItem->orderItemPrice, 'out_of_production')
                                ->checkbox([
                                    'id' => 'orderitemprice-out_of_production' . $orderItem->id,
                                    'name' => 'OrderItemPrice[' . $orderItem->product_id . '][out_of_production]',
                                    'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true,
                                    'class' => 'field-orderitemprice-out_of_production outof-prod-checkbox'
                                ], false);
                            ?>
                        </td>
                    </tr>

                </table>

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
                                            Url::toRoute(['/catalog/factory/pdf-viewer']) . '?file=' . $fileLink . '&search=' . $orderItem->product->article,
                                            [
                                                'target' => '_blank',
                                                'class' => 'click-on-factory-file',
                                                'data-id' => $priceFile->id
                                            ]
                                        ) ?>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    <?php } ?>
                </div>

            </div>
        <?php } ?>

    </div>

    <div class="form-wrap">
        <div class="form-group">
            <?php if ($modelOrder->orderAnswers) { ?>
                <div><?= Yii::t('app', 'Response time') ?>:</div>
                <?php foreach ($modelOrder->orderAnswers as $key => $answer) {
                    if ($answer->user->group->role == 'partner') {
                        echo '<div><strong>' . $answer['user']['profile']->getNameCompany() . '</strong></div>';
                    } elseif ($answer->user->group->role == 'factory') {
                        echo '<div><strong>' . $answer['user']['profile']['factory']['title'] . '</strong></div>';
                    }
                    echo '<div>' . ($key + 1) . ') ' . $answer->getAnswerTime() . '</div>';
                } ?>
            <?php } ?>
        </div>

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
    echo Html::submitButton(
        Yii::t('app', 'Отправить ответ клиенту'),
        [
            'class' => 'btn btn-success action-save-answer',
            'name' => 'action-save-answer',
            'value' => 1
        ]
    );
} ?>

<?php ActiveForm::end(); ?>
