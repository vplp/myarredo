<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\components\Breadcrumbs;
use frontend\modules\payment\models\Payment;

/** @var $modelPayment Payment */

$this->title = Yii::t('app', 'Тарифы');
?>

    <main>
        <div class="page category-page">
            <div class="largex-container itprod-box">
                <div class="row title-cont">

                    <?= Html::tag('h1', Yii::t('app', 'Тарифы')); ?>

                    <?= Breadcrumbs::widget([
                        'links' => $this->context->breadcrumbs,
                    ]) ?>

                </div>

                <div class="row accountbox">

                    <?php $form = ActiveForm::begin([
                        'action' => Url::toRoute(['/payment/payment/invoice']),
                    ]); ?>

                    <!-- tarif col -->
                    <div class="col-md-4">

                        <!-- tarifbox -->
                        <div class="tarifbox">
                            <div class="tarif-title"><?= Yii::t('app', 'Тариф на полгода') ?></div>
                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку по России') ?></div>
                            <div class="tarif-fotnote">* <?= Yii::t('app', 'кроме Москвы и Санк-Петербурга') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку по России (полгода)'),
                                    'data-price' => 60000
                                ]) . Html::label('60 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку на Москву') ?></div>

                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку на Москву (полгода)'),
                                    'data-price' => 30000
                                ]) . Html::label('30 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку на Санк-Петербург') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку на Санк-Петербург (полгода)'),
                                    'data-price' => 10000
                                ]) . Html::label('10 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>
                        </div>
                        <!-- end tarifbox -->

                    </div>
                    <!-- end tarif col -->

                    <!-- tarif col -->
                    <div class="col-md-4">

                        <!-- tarifbox -->
                        <div class="tarifbox">
                            <div class="tarif-title"><?= Yii::t('app', 'Тариф на 3 месяца') ?></div>
                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку по России') ?></div>
                            <div class="tarif-fotnote">* <?= Yii::t('app', 'кроме Москвы и Санк-Петербурга') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку по России (3 месяца)'),
                                    'data-price' => 40000
                                ]) . Html::label('40 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку на Москву') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку на Москву (3 месяца)'),
                                    'data-price' => 20000
                                ]) . Html::label('20 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку на Санк-Петербург') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку на Санк-Петербург (3 месяца)'),
                                    'data-price' => 8000
                                ]) . Html::label('8 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                        </div>
                        <!-- end tarifbox -->

                    </div>
                    <!-- end tarif col -->

                    <!-- tarif col -->
                    <div class="col-md-4">

                        <!-- tarifbox -->
                        <div class="tarifbox">
                            <div class="tarif-title"><?= Yii::t('app', 'Другие страны (год)') ?></div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку с Беларусии') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку с Беларусии (год)'),
                                    'data-price' => 20000
                                ]) . Html::label('20 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку с Италии') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку с Италии (год)'),
                                    'data-price' => 40000
                                ]) . Html::label('40 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>

                            <div class="tarif-subtitle"><?= Yii::t('app', 'Получать заявку с Украины') ?></div>
                            <div class="tarif-checkpanel">
                                <?= Html::checkbox('Payment[tariffs][]', false, [
                                    'value' => Yii::t('app', 'Получать заявку с Украины (год)'),
                                    'data-price' => 25000
                                ]) . Html::label('25 000 ' . $modelPayment->currency, false, ['class' => 'label-check']); ?>
                            </div>
                        </div>
                        <!-- end tarifbox -->

                    </div>
                    <!-- end tarif col -->

                    <div class="col-xs-12">

                        <!-- tarif-total-panel -->
                        <div class="tarif-total-panel">
                            <div class="tarif-totlal">
                                <?= Yii::t('app', 'Итого') ?>:
                                <span class="total-amount">0</span> <?= $modelPayment->currency ?>
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
                                    ['class' => 'btn btn-myarredo']
                                ) ?>
                            </div>
                        </div>
                        <!-- end tarif-total-panel -->

                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </main>

<?php
$script = <<<JS

const fieldName = 'input[type="checkbox"][name="Payment[tariffs][]"]';

$('body').on('change', fieldName, function() {
    let totalAmount = 0;
    
    $(fieldName).each(function() {
        const tariff = $(this);
        
        if (tariff.prop('checked') === true) {
            totalAmount = totalAmount + tariff.data('price');
        }
    });

    $('.total-amount').text(totalAmount);
    $('input[name="Payment[amount]"]').val(totalAmount);
});
JS;

$this->registerJs($script);
