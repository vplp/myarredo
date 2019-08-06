<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\shop\models\{
    Order, OrderItem, OrderAnswer
};
use frontend\modules\catalog\models\ItalianProduct;

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

            <?php
            foreach ($modelOrder->items as $orderItem) { ?>
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
                            <td colspan="2">
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
                                <?= $orderItem->product['factory']['title'] ?>
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
                                <?= $orderItem->product['region']['title'] ?>
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

<?php
if (Yii::$app->user->identity->profile->getPossibilityToSaveAnswer($modelOrder->city_id) != null) {
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
} else {
    echo Html::tag('p', Yii::t('app', 'Оплатите возможность отвечать на заявки из этого города!'));
} ?>

<?php ActiveForm::end(); ?>
