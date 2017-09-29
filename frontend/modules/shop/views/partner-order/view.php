<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $product \frontend\modules\catalog\models\Product */
/* @var $item \frontend\modules\shop\models\CartItem */

?>

<main>
    <div class="page notebook-page">
        <div class="container large-container">
            <div class="row">
                <div class="col-md-12">
                    <?= Html::tag('h2', $this->context->title) ?>
                </div>
                <div class="col-md-8">

                    <div class="flex basket-items">
                        <?php foreach ($order->items as $item): ?>
                            <div class="basket-item-info">
                                <div class="item">
                                    <div class="img-cont">
                                        <?= Html::a(Html::img($item->product->getImage()), Product::getUrl($item->product['alias'])) ?>
                                    </div>
                                    <table width="100%">
                                        <tr>
                                            <td>Предмет</td>
                                            <td><?= $item->product['lang']['title'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Фабрика</td>
                                            <td><?= $item->product['factory']['lang']['title'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="best-price-form">
                        <?php $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => $order->getPartnerOrderUrl(),
                            'id' => 'checkout-form',
                        ]); ?>

                        <?= $form->field($order, 'comment')->textarea(['disabled' => true]) ?>
                        <p>Ваш ответ</p>
                        <p>РЕЗУЛЬТАТ</p>

                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success big']) ?>

                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>