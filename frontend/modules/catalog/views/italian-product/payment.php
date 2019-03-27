<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\catalog\models\ItalianProduct;

$this->title = $this->context->title;

/** @var \frontend\modules\payment\models\Payment $modelPayment */

?>

<main>
    <div class="page create-sale page-reclamations">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="column-center">
                <div class="form-horizontal">

                    <div>
                        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_PAYMENT_TEXT') ?>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'action' => Url::toRoute(['/payment/payment/invoice'])
                    ]); ?>

                    <div id="list-product">
                        <?php
                        foreach ($models as $product) {
                            echo '<div class="list-product-item">' .
                                $product->lang->title .
                                Html::input(
                                    'hidden',
                                    'Payment[items_ids][]',
                                    $product->id
                                ) .
                                Html::img(
                                    ItalianProduct::getImageThumb($product['image_link']),
                                    ['width' => 50]
                                ) .
                                Html::a(
                                    '<i class="fa fa-times"></i></a>',
                                    "javascript:void(0);",
                                    [
                                        'id' => 'del-product',
                                        'class' => 'close',
                                        'data-id' => $product->id
                                    ]
                                ) .
                                '</div>';
                        } ?>
                    </div>

                    <div><?= Yii::t('app', 'Всего к оплате') ?>
                        : <?= $modelPayment->amount . ' ' . $modelPayment->currency ?></div>

                    <?php
                    echo $form
                            ->field($modelPayment, 'amount')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'user_id')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'type')
                            ->label(false)
                            ->input('hidden') .
                        $form
                            ->field($modelPayment, 'currency')
                            ->label(false)
                            ->input('hidden');

                    echo Html::tag(
                        'div',
                        Html::submitButton(
                            Yii::t('app', 'Перейти к оплате'),
                            ['class' => 'btn btn-goods', 'name' => 'payment', 'value' => 1]
                        ) . '&nbsp;' . Html::a(
                            Yii::t('app', 'Вернуться к списку'),
                            ['/catalog/italian-product/list'],
                            ['class' => 'btn btn-cancel']
                        ),
                        ['class' => 'buttons-cont']
                    );

                    ActiveForm::end();
                    ?>

                </div>
            </div>
        </div>
    </div>
</main>