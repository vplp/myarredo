<?php

use yii\helpers\{
    Html, Url
};
//
use yii\widgets\ActiveForm;
//
use frontend\modules\payment\models\Payment;
use frontend\modules\location\models\Currency;
use frontend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var ItalianProduct $model
 * @var ItalianProductLang $modelLang
 * @var Payment $modelPayment
 */

$modelPayment = new Payment();
$modelPayment->setScenario('frontend');

$modelPayment->user_id = Yii::$app->user->id;
$modelPayment->type = 'italian_item';

$currency = Currency::findByCode2('EUR');

/** @var Currency $amount */

/**
 * cost 1 product = 5 EUR
 * conversion to RUB
 */
$cost = 5 * $currency->course;

$amount = $cost + ($cost * 0.02);
$amount = number_format($amount, 2, '.', '');

$total = $amount;
$nds = $total / 100 * 20;
$modelPayment->amount = number_format($total + $nds, 2, '.', '');
$modelPayment->currency = 'RUB';
?>

<div class="form-horizontal add-itprod-content">

    <!-- steps box -->
    <div class="progress-steps-box">
        <div class="progress-steps-step<?= !Yii::$app->request->get('step') ? ' active' : '' ?>">
            <span class="step-numb">1</span>
            <span class="step-text"><?= Yii::t('app', 'Информация про товар') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'photo' ? ' active' : '' ?>">
            <span class="step-numb">2</span>
            <span class="step-text"><?= Yii::t('app', 'Фото товара') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'check' ? ' active' : '' ?>">
            <span class="step-numb">3</span>
            <span class="step-text"><?= Yii::t('app', 'Проверка товара') ?></span>
        </div>
        <div class="progress-steps-step<?= Yii::$app->request->get('step') == 'payment' ? ' active' : '' ?>">
            <span class="step-numb">4</span>
            <span class="step-text"><?= Yii::t('app', 'Оплата') ?></span>
        </div>
    </div>
    <!-- steps box end -->

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

                    <div class="wrap-table-totalpay">
                        <table class="table table-bordered table-totalpay">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th><?= Yii::t('app', 'Наименование услуг') ?></th>
                                <th><?= Yii::t('app', 'Количество') ?></th>
                                <th><?= Yii::t('app', 'Цена') ?></th>
                                <th><?= Yii::t('app', 'Валюта') ?></th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th>1</th>
                                    <td class="cell-img-and-descr">
                                        <?= $model->getTitle() .
                                        Html::input(
                                            'hidden',
                                            'Payment[items_ids][]',
                                            $model->id
                                        ) .
                                        Html::img(
                                            ItalianProduct::getImageThumb($model['image_link']),
                                            ['width' => 50]
                                        ) ?>
                                    </td>
                                    <td>1</td>
                                    <td><?= $amount ?></td>
                                    <td><?= $modelPayment->currency ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="total-box">
                        <div>
                           <span class="for-total"> <?= Yii::t('app', 'Итого') ?> :</span> <span class="for-styles"><?= $total . ' ' . $modelPayment->currency ?></span>
                        </div>
                        <div>
                        <span class="for-total">
                            <?= Yii::t('app', 'В том числе НДС') ?> :
                        </span>
                            <span class="for-styles"><?= $nds . ' ' . $modelPayment->currency ?></span>
                        </div>
                        <div>
                            <span class="for-total">
                                <?= Yii::t('app', 'Всего к оплате') ?> :
                            </span>
                            <span class="for-styles"><?= $modelPayment->amount . ' ' . $modelPayment->currency ?></span>
                        </div>
                    </div>

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

</div>

<!-- rules box -->
<div class="add-itprod-rules">
    <div class="add-itprod-rules-item">

        <?= Yii::$app->param->getByName('ITALIAN_PRODUCT_STEP4_TEXT') ?>

    </div>
</div>
<!-- rules box end -->

