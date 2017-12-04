<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\shop\models\Order */

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => $model->getPartnerOrderOnListUrl(),
]); ?>

    <div class="hidden-order-in">
        <div class="flex-product">

            <?php
            foreach ($model->items as $orderItem) {
                echo $this->render('_list_item_product', [
                    'form' => $form,
                    'order' => $model,
                    'orderItem' => $orderItem,
                ]);
            } ?>

        </div>
        <div class="form-wrap">

            <?= $form
                ->field($model->orderAnswer, 'answer')
                ->textarea(['rows' => 5]) ?>

            <?= $form
                ->field($model->orderAnswer, 'id')
                ->input('hidden')
                ->label(false) ?>

            <?= $form
                ->field($model->orderAnswer, 'order_id')
                ->input('hidden', ['value' => $model->id])
                ->label(false) ?>

            <?= $form->field($model, 'comment')
                ->textarea(['disabled' => true, 'rows' => 5]) ?>

            <?= $form->field($model->orderAnswer, 'results')
                ->textarea(['rows' => 5]) ?>

        </div>
    </div>

<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-success',
    'name' => 'action-save-answer',
    'value' => 1
]) ?>

<?php if ($model->orderAnswer->id && $model->orderAnswer->answer_time == 0) {
    echo Html::submitButton('Отправить ответ клиенту', [
        'class' => 'btn btn-success',
        'name' => 'action-send-answer',
        'value' => 1
    ]);
} ?>

<?php ActiveForm::end(); ?>