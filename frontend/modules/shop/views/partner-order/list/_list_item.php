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

$user = Yii::$app->user->identity;
$dealers_can_answer = [];
$factoryDealersId = [];

if ($user->profile->getPossibilityToAnswer($modelOrder)) { ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data' => ['pjax' => true]],
        'action' => $modelOrder->getPartnerOrderOnListUrl(),
    ]); ?>

    <div class="hidden-order-in ordersanswer-box">
        <div class="flex-product orderanswer-cont">

            <?php if ($modelOrder->items) {
                foreach ($modelOrder->items as $orderItem) {
                    $dealers_can_answer[] = $orderItem->product->factory
                        ? $orderItem->product->factory->dealers_can_answer
                        : 0;

                    $factoryDealersId = $orderItem->product->factory
                        ? array_merge($factoryDealersId, $orderItem->product->factory->getFactoryDealersIds())
                        : $factoryDealersId;
                    ?>
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
                                        Product::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                                        ['class' => 'productlink']
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
                                    <?= $form
                                        ->field($orderItem->orderItemPrice, 'product_id')
                                        ->input('hidden', [
                                            'name' => 'OrderItemPrice[' . $orderItem->product_id . '][product_id]',
                                            'class' => 'order-productid-hfield'
                                        ])
                                        ->label(false);
                                    ?>
                                    <div class="form-twoboxl">
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
                                        <?= $form
                                            ->field(
                                                $orderItem->orderItemPrice,
                                                'currency'
                                            )
                                            ->dropDownList($orderItem->orderItemPrice::currencyRange(), ['name' => 'OrderItemPrice[' . $orderItem->product_id . '][currency]'])
                                            ->label(false);
                                        ?>
                                    </div>
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

                        <?php if (!Yii::$app->getUser()->isGuest && $user->profile->isPdfAccess()) { ?>
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
                        <?php } ?>

                        <?php if ($orderItem->product['factory']['lang'] && $orderItem->product['factory']['lang']['working_conditions']) {
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

    <?php
    // Только дилеры Фабрики отвечает на запросы
    if ($user->profile->getPossibilityToSaveAnswer($modelOrder) != null && $user->profile->getPossibilityToSaveAnswerPerMonth()) {
        if (in_array(1, $dealers_can_answer) && !in_array(Yii::$app->user->identity->id, $factoryDealersId)) {
            echo Yii::t('app', 'Чтобы ответить на данный запрос, Вы должны стать дилером данной фабрики.');
        } elseif (!$modelOrderAnswer->id) {
            echo Html::submitButton(
                Yii::t('app', 'Отправить ответ клиенту'),
                [
                    'class' => 'btn btn-success action-save-answer',
                    'name' => 'action-save-answer',
                    'value' => 1
                ]
            );
        }
    } elseif ($user->profile->getPossibilityToSaveAnswer($modelOrder) && $user->profile->getPossibilityToSaveAnswerPerMonth() == false) {
        echo Html::tag('p', Yii::t('app', 'Вы исчерпали бесплатный месячный лимит ответов на заявки. Для продления свяжитесь с оператором сайта.'));
    } else {
        echo Html::tag('p', Yii::t('app', 'Для ответа на данные заявки свяжитесь с оператором сайта, тел.:') . ' +7 968 353 36 36, e-mail: help@myarredo.ru');
    } ?>

    <?php ActiveForm::end(); ?>

<?php } else { ?>
    <div class="hidden-order-in">
        <div class="flex-product orderanswer-cont">

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
