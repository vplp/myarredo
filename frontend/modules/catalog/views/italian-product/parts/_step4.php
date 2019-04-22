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

/**
 * cost 1 product = 5 EUR
 * conversion to RUB
 */
$cost = 5;

$currency = Currency::findByCode2('EUR');
/** @var Currency $amount */
$amount = ceil($cost * $currency->course + 1 * $currency->course + 0.12 * $currency->course);
$amount = number_format($amount, 2, '.', '');

$modelPayment->amount = number_format($amount, 2, '.', '');
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

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th><?= Yii::t('app', 'Наименование услуг') ?></th>
                            <th><?= Yii::t('app', 'Количество') ?></th>
                            <th><?= Yii::t('app', 'Цена') ?></th>
                            <th><?= Yii::t('app', 'Сумма') ?></th>
                            <th><?= Yii::t('app', 'Валюта') ?></th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th>1</th>
                                <td>
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
                                <td><?= $amount ?></td>
                                <td><?= $modelPayment->currency ?></td>
                            </tr>

                        </tbody>
                    </table>

                    <div>
                        <?= Yii::t('app', 'Итого') ?>: <?= $modelPayment->amount . ' ' . $modelPayment->currency ?>
                    </div>
                    <div>
                        <?= Yii::t('app', 'В том числе НДС') ?>
                        : <?= '0 ' . $modelPayment->currency ?>
                    </div>
                    <div>
                        <?= Yii::t('app', 'Всего к оплате') ?>
                        : <?= $modelPayment->amount . ' ' . $modelPayment->currency ?>
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

