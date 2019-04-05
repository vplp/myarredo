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
    'action' => $modelOrder->getPartnerOrderOnListUrl(),
]) ?>

    <div class="hidden-order-in ordersanswer-box">
        <div class="flex-product orderanswer-cont">

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
                                    <?= Yii::t('app', 'Region') ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="spec-pad2">
                                <?= $orderItem->product['region'] ?>
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

                    <?php if (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->profile->isPdfAccess()) { ?>
                        <div class="downloads">

                            <?php if (!empty($orderItem->product['factoryPricesFiles'])) { ?>
                                <p class="title-small"><?= Yii::t('app', 'Посмотреть прайс листы') ?></p>
                                <ul>
                                    <?php foreach ($orderItem->product['factoryPricesFiles'] as $priceFile) {
                                        if ($fileLink = $priceFile->getFileLink()) { ?>
                                            <li>
                                                <?= Html::a($priceFile->title, $fileLink, ['target' => '_blank']) ?>
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
    if ((!$modelOrderAnswer->id || $modelOrderAnswer->answer_time == 0)) {
        echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success action-save-answer',
            'name' => 'action-save-answer',
            'value' => 1]);
    }
} else {
    echo '<p>Оплатите возможность отвечать на заявки из этого города!</p>';
} ?>

<?php ActiveForm::end(); ?>


<?php
if (Yii::$app->user->identity->profile->getPossibilityToSaveAnswer($modelOrder->city_id) != null &&
    ($modelOrderAnswer->id && $modelOrderAnswer->answer_time == 0)) {
    $form = ActiveForm::begin(['id' => 'OrderAnswerForm',
        'options' => ['data' => ['pjax' => true]],
        'action' => Url::toRoute(['/shop/partner-order/send-answer']),]);

    echo $form
        ->field($modelOrderAnswer, 'id')
        ->input('hidden')
        ->label(false);

    echo $form
        ->field($modelOrderAnswer, 'order_id')
        ->input('hidden', ['value' => $modelOrder->id])
        ->label(false);

    echo Html::submitButton('Отправить ответ клиенту', ['class' => 'btn btn-success',
        'name' => 'action-send-answer',
        'value' => 1]);

    ActiveForm::end();
}
