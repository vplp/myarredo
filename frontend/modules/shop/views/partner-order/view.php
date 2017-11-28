<?php

use yii\helpers\{
    Html, Url
};
use frontend\components\Breadcrumbs;
use yii\widgets\ActiveForm;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $product \frontend\modules\catalog\models\Product */
/* @var $item \frontend\modules\shop\models\CartItem */
/* @var $model \frontend\modules\shop\models\Order */

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
                    <div class="col-md-8">

                        <div class="flex basket-items">
                            <?php foreach ($model->items as $item): ?>

                                <?= $this->render('_list_item', [
                                    'item' => $item,
                                ]) ?>

                            <?php endforeach; ?>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="best-price-form">
                            <?php $form = ActiveForm::begin([
                                'method' => 'post',
                                'action' => $model->getPartnerOrderUrl(),
                                'id' => 'checkout-form',
                            ]); ?>

                            <?= $form->field($modelAnswer, 'answer')->textarea() ?>
                            <?= $form->field($model, 'comment')->textarea(['disabled' => true]) ?>

                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success big']) ?>

                            <?php ActiveForm::end(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>