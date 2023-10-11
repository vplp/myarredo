<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\components\Breadcrumbs;
use frontend\modules\shop\models\Order;
use frontend\modules\shop\models\CartItem;
use frontend\modules\catalog\models\ItalianProduct;

/* @var $this yii\web\View */
/* @var $product ItalianProduct */
/* @var $item CartItem */
/* @var $model Order */

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <?= Html::tag('h2', $this->context->title) ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                ]) ?>
            </div>
            <div class="cat-content">
                <div class="row">

                    <?php $form = ActiveForm::begin([
                        'method' => 'post',
                        'action' => $model->getPartnerOrderUrl(),
                    ]); ?>

                    <div class="col-md-8">

                        <div class="flex basket-items">
                            <?php foreach ($model->items as $orderItem) {
                                echo $this->render('_list_item_product', [
                                    'form' => $form,
                                    'orderItem' => $orderItem,
                                ]);
                            } ?>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="best-price-form">

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

                    <?= Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-success',
                        'name' => 'action-save-answer',
                        'value' => 1
                    ]) ?>

                    <?php if ($model->orderAnswer->id) {
                        echo Html::submitButton('Отправить ответ клиенту', [
                            'class' => 'btn btn-success',
                            'name' => 'action-send-answer',
                            'value' => 1
                        ]);
                    } ?>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</main>