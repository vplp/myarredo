<?php

use yii\helpers\{
    Html, Url
};
//
use yii\widgets\ActiveForm;
//
use frontend\modules\payment\models\Payment;
use frontend\modules\location\models\Currency;
use frontend\modules\catalog\models\ItalianProduct;

/**
 * @var \frontend\modules\catalog\models\ItalianProduct $model
 * @var \frontend\modules\catalog\models\ItalianProductLang $modelLang
 * @var \frontend\modules\payment\models\Payment $modelPayment
 */


$modelPayment = new Payment();
$modelPayment->setScenario('frontend');

$modelPayment->user_id = Yii::$app->user->id;
$modelPayment->type = 'italian_item';

/**
 * cost 1 product = 5 EUR
 * conversion to RUB
 */
$cost = 0.2;

$currency = Currency::findByCode2('EUR');
/** @var Currency $amount */
$amount = ($cost * $currency->course + 1 * $currency->course + 0.12 * $currency->course);

$modelPayment->amount = number_format(
    ceil($amount),
    2,
    '.',
    ''
);
$modelPayment->currency = 'RUB';

?>
<div class="page create-sale page-reclamations">
    <div class="largex-container">

        <div class="column-center">
            <div class="form-horizontal">

                <div>
                    <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_PAYMENT_TEXT') ?>
                </div>

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/payment/payment/invoice']),
                ]); ?>

                <div id="list-product">
                    <div class="list-product-item">
                        <?php
                        /** @var ItalianProduct $product */
                        echo $model->getTitle() .
                            Html::input(
                                'hidden',
                                'Payment[items_ids][]',
                                $model->id
                            ) .
                            Html::img(
                                ItalianProduct::getImageThumb($model['image_link']),
                                ['width' => 50]
                            ) ?>
                    </div>

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
                ?>

                <div class="buttons-cont">
                    <?= Html::submitButton(
                        Yii::t('app', 'Оплатить'),
                        ['class' => 'btn btn-success']
                    ) ?>

                    <?= Html::a(
                        Yii::t('app', 'Cancel'),
                        ['/catalog/italian-product/list'],
                        ['class' => 'btn btn-primary']
                    ) ?>
                </div>


                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
