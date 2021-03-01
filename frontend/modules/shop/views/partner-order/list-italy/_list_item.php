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
    ItalianProduct, Factory
};

/* @var $this yii\web\View */
/* @var $modelOrder Order */
/* @var $modelOrderAnswer OrderAnswer */
/* @var $orderItem OrderItem */

?>

<?php $form = ActiveForm::begin([
    'id' => 'OrderAnswerForm',
    'options' => ['data' => ['pjax' => true]],
    'action' => $modelOrder->getPartnerOrderOnListUrl(),
]) ?>

<div class="hidden-order-in ordersanswer-box">
    <div class="flex-product orderanswer-cont">

        <?php foreach ($modelOrder->items as $orderItem) { ?>
            <div class="basket-item-info">
                <div class="img-cont">
                    <?php if (ItalianProduct::isPublished($orderItem->product['alias'])) {
                        echo Html::a(
                            Html::img(ItalianProduct::getImageThumb($orderItem->product['image_link'])),
                            ItalianProduct::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                            ['target' => '_blank']
                        );
                    } else {
                        echo Html::img(ItalianProduct::getImageThumb($orderItem->product['image_link']));
                    } ?>
                </div>
                <table class="char" width="100%">
                    <tr>
                        <td colspan="2">
                            <?php if (ItalianProduct::isPublished($orderItem->product['alias'])) {
                                Html::a(
                                    $orderItem->product->getTitle(),
                                    ItalianProduct::getUrl($orderItem->product[Yii::$app->languages->getDomainAlias()]),
                                    ['class' => 'productlink']
                                );
                            } else {
                                echo $orderItem->product->getTitle();
                            } ?>
                        </td>
                    </tr>
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
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Предмет') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $orderItem->product['types']['lang']['title'] ?>
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
                            <?php if ($orderItem->product['factory'] && $orderItem->product['factory']['title']) {
                                echo Html::a(
                                    $orderItem->product['factory']['title'],
                                    Factory::getUrl($orderItem->product['factory']['alias'])
                                );
                            } else {
                                echo $orderItem->product['factory_name'];
                            } ?>
                        </td>
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
                            <?= $orderItem->product['region']['title'] ?? '' ?>
                        </td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= $orderItem->product->getAttributeLabel('volume') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $orderItem->product['volume'] ?>
                        </td>
                    </tr>
                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= $orderItem->product->getAttributeLabel('weight') ?>
                                </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="spec-pad2">
                            <?= $orderItem->product['weight'] ?>
                        </td>
                    </tr>

                    <?php if (!empty($orderItem->product['specificationValue'])) { ?>
                        <tr class="noborder">
                            <td colspan="2" class="spec-pad">
                                <span class="for-ordertable">
                                    <?= Yii::t('app', 'Размеры') ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="spec-pad2">
                                <?php
                                foreach ($orderItem->product['specificationValue'] as $item) {
                                    if ($item['specification']['parent_id'] == 4 && $item['val']) {
                                        echo Html::beginTag('div') .
                                            $item['specification']['lang']['title'] .
                                            ' (' . Yii::t('app', 'см') . ')' .
                                            ': ' .
                                            $item['val'] .
                                            Html::endTag('div');
                                    }
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr class="noborder">
                        <td colspan="2" class="spec-pad">
                            <span class="for-ordertable">
                                <?= Yii::t('app', 'Цена доставки') ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?= $form
                                ->field($orderItem->orderItemPrice, 'product_id')
                                ->input('hidden', [
                                    'name' => 'OrderItemPrice[' . $orderItem->product_id . '][product_id]',
                                ])
                                ->label(false);
                            ?>
                            <div class="form-twoboxl">
                                <?= $form
                                    ->field($orderItem->orderItemPrice, 'price')
                                    ->input('text', [
                                        'name' => 'OrderItemPrice[' . $orderItem->product_id . '][price]',
                                        'value' => $orderItem->orderItemPrice->price ?? 0,
                                        'disabled' => ($modelOrder->orderAnswer->answer_time == 0) ? false : true
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
                </table>

                <?php if (isset($orderItem->product['factory']['lang']) && $orderItem->product['factory']['lang']['working_conditions']) {
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

        <?php } ?>

    </div>
    <div class="form-wrap">

        <?= $form->field($modelOrder, 'comment')
            ->textarea(['rows' => 5, 'disabled' => true]) ?>

        <?= $form
            ->field($modelOrderAnswer, 'answer')
            ->textarea(['rows' => 5,
                'disabled' => (!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0) ? false : true]) ?>

        <?= $form
            ->field($modelOrderAnswer, 'id')
            ->input('hidden')
            ->label(false) ?>

        <?= $form
            ->field($modelOrderAnswer, 'order_id')
            ->input('hidden', ['value' => $modelOrder->id])
            ->label(false) ?>

        <?php if ($modelOrder->orderAnswer->id && $modelOrder->orderAnswer->answer_time != 0) { ?>
            <div><strong><?= Yii::t('app', 'Контактные данные продавца') ?>:</strong></div>
            <?php foreach ($modelOrder->items as $orderItem) { ?>
                <div><?= Yii::t('app', 'Phone') ?>: <?= $orderItem->product['user']['profile']['phone'] ?></div>
                <div>Email: <?= $orderItem->product['user']['email'] ?></div>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php if (Yii::$app->user->identity->profile->getPossibilityToSaveAnswer($modelOrder) != null && Yii::$app->user->identity->profile->getPossibilityToSaveAnswerPerMonth()) {
    if (!$modelOrderAnswer->id) {
        echo Html::submitButton(
            Yii::t('app', 'Отправить ответ клиенту'),
            [
                'class' => 'btn btn-success action-save-answer',
                'name' => 'action-save-answer',
                'value' => 1
            ]
        );
    }
} elseif (Yii::$app->user->identity->profile->getPossibilityToSaveAnswer($modelOrder) && Yii::$app->user->identity->profile->getPossibilityToSaveAnswerPerMonth() == false) {
    echo Html::tag('p', Yii::t('app', 'Вы исчерпали бесплатный месячный лимит ответов на заявки. Для продления свяжитесь с оператором сайта.'));
} else {
    echo Html::tag('p', Yii::t('app', 'Оплатите возможность отвечать на заявки из этого города!'));
} ?>

<?php ActiveForm::end(); ?>

