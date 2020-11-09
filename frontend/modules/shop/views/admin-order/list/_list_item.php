<?php

use yii\helpers\{
    Html, Url
};
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\{
    Order, OrderItem, OrderAnswer
};
use frontend\modules\catalog\models\{
    Product, Factory
};

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $modelOrderAnswer OrderAnswer */
/* @var $orderItem OrderItem */

?>

<?php $form = ActiveForm::begin([
    'options' => ['data' => ['pjax' => true]],
    'action' => $modelOrder->getPartnerOrderOnListUrl(),
]); ?>

<div class="hidden-order-in ordersanswer-box">
    <div class="flex-product orderanswer-cont">

        <?php if ($modelOrder->items) {
            foreach ($modelOrder->items as $orderItem) { ?>
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
                            <td colspan="2">
                                <?= Html::a(
                                    $orderItem->product['lang']['title'],
                                    Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()])
                                ); ?>
                            </td>
                        </tr>

                        <?php if (!$orderItem->product['is_composition']) { ?>
                            <tr>
                                <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Артикул') ?>
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="spec-pad2">
                                    <?= $orderItem->product['article'] ?>
                                </td>
                            </tr>
                        <?php } ?>

                        <tr class="noborder">
                            <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Factory') ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="spec-pad2">
                                <?= Html::a(
                                    $orderItem->product['factory']['title'],
                                    Factory::getUrl($orderItem->product['factory']['alias'])
                                ); ?>
                            </td>
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
                                <?php
                                foreach ($orderItem->orderItemPrices as $price) {
                                    echo '<div><strong>' . $price['user']['profile']['lang']['name_company'] . '</strong></div>' .
                                        '<div>' . $price['user']['email'] . '</div>' .
                                        '<div><strong>' . ($price['out_of_production'] == '1' ? Yii::t('app', 'Снят с производства') : $price['price']) . '</strong></div><br>';
                                }
                                ?>

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
                            <ul class="pricelist">
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

                    <?php if ($orderItem->product['factory']['lang']['working_conditions']) {
                        echo Html::button(Yii::t('app', 'Условия работы'), [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'modal',
                            'data-target' => '#' . 'working_conditions-modal_' . $orderItem['id'],
                        ]);

                        Modal::begin([
                            'header' => Yii::t('app', 'Условия работы') . ' ' . $orderItem->product['factory']['title'],
                            'id' => 'working_conditions-modal_' . $orderItem['id']
                        ]);

                        echo $orderItem->product['factory']['lang']['working_conditions'];

                        Modal::end();
                    } ?>
                </div>

            <?php }
        } else {
            echo Yii::t('app', 'Клиент оставил данную заявку, так как не нашел то что искал на сайте.');
        } ?>

        <?php if ($modelOrder->image_link) { ?>
            <div class="basket-item-info">
                <div class="img-cont">
                    <?= Html::img($modelOrder->getImageLink()); ?>
                </div>
            </div>
        <?php } ?>

    </div>
    <div class="form-wrap">
        <div class="form-group">

            <?= $form->field($modelOrder, 'comment')
                ->textarea(['rows' => 5, 'disabled' => true]) ?>

            <?php foreach ($modelOrder->orderAnswers as $answer) {
                echo '<div><strong>' . $answer['user']['profile']['lang']['name_company'] . '</strong></div>' .
                    '<div>' . $answer['user']['email'] . '</div>' .
                    '<div>' . $answer->getAnswerTime() . '</div>' .
                    '<div>' . $answer['answer'] . '</div><br>';
            } ?>

            <?php if ($modelOrder->lang != 'ru-RU') {
                echo $form
                    ->field($modelOrder, 'admin_comment')
                    ->textarea(['rows' => 5]);
            } ?>

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
</div>

<?php if (!$modelOrderAnswer->id && !$modelOrder->isArchive()) {
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
