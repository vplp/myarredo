<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelOrder \frontend\modules\shop\models\Order */

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => $modelOrder->getPartnerOrderOnListUrl(),
]); ?>

    <div class="hidden-order-in">
        <div class="flex-product">

            <?php
            foreach ($modelOrder->items as $orderItem) {
                echo $this->render('_list_item_product', [
                    'form' => $form,
                    'modelOrder' => $modelOrder,
                    'orderItem' => $orderItem,
                ]);
            } ?>

        </div>
        <div class="form-wrap">

            <?= $form
                ->field($modelOrder->orderAnswer, 'answer')
                ->textarea(['rows' => 5]) ?>

            <?= $form
                ->field($modelOrder->orderAnswer, 'id')
                ->input('hidden')
                ->label(false) ?>

            <?= $form
                ->field($modelOrder->orderAnswer, 'order_id')
                ->input('hidden', ['value' => $modelOrder->id])
                ->label(false) ?>

            <?= $form->field($modelOrder, 'comment')
                ->textarea(['disabled' => true, 'rows' => 5]) ?>

            <?= $form->field($modelOrder->orderAnswer, 'results')
                ->textarea(['rows' => 5]) ?>

        </div>
    </div>

<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-success',
    'name' => 'action-save-answer',
    'value' => 1
]) ?>

<?php if ($modelOrder->orderAnswer->id && $modelOrder->orderAnswer->answer_time == 0) {
    echo Html::submitButton('Отправить ответ клиенту', [
        'class' => 'btn btn-success',
        'name' => 'action-send-answer',
        'value' => 1
    ]);
} ?>

<?php ActiveForm::end(); ?>