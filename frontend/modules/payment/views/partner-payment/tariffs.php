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

                <div class="row">

                    <?php $form = ActiveForm::begin([
                        'action' => Url::toRoute(['/payment/payment/invoice']),
                    ]); ?>

                    <div class="col-md-3 col-lg-3">
                        <div>Тариф на год</div>
                        <div>
                            Получать заявку по России
                            <br>
                            * кроме Москвы и Санк-Петербурга
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку по России (год)',
                                'data-price' => 60000
                            ]) . Html::label('60 000 ' . $modelPayment->currency) ?>
                        </div>
                        <div>
                            Получать заявку на Москву
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку на Москву (год)',
                                'data-price' => 30000
                            ]) . Html::label('30 000 ' . $modelPayment->currency) ?>
                        </div>
                        <div>
                            Получать заявку на Санк-Петербург
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку на Санк-Петербург (год)',
                                'data-price' => 10000
                            ]) . Html::label('10 000 ' . $modelPayment->currency) ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div>Тариф на полгода</div>
                        <div>
                            Получать заявку по России
                            <br>
                            * кроме Москвы и Санк-Петербурга
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку по России (полгода)',
                                'data-price' => 40000
                            ]) . Html::label('40 000 ' . $modelPayment->currency) ?>
                        </div>
                        <div>
                            Получать заявку на Москву
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку на Москву (полгода)',
                                'data-price' => 20000
                            ]) . Html::label('20 000 ' . $modelPayment->currency) ?>
                        </div>
                        <div>
                            Получать заявку на Санк-Петербург
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку на Санк-Петербург (полгода)',
                                'data-price' => 8000
                            ]) . Html::label('8 000 ' . $modelPayment->currency) ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <div>Другие страны (год)</div>
                        <div>
                            Получать заявку с Беларусии
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку с Беларусии (год)',
                                'data-price' => 20000
                            ]) . Html::label('20 000 ' . $modelPayment->currency) ?>
                        </div>
                        <div>
                            Получать заявку с Италии
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку с Италии (год)',
                                'data-price' => 40000
                            ]) . Html::label('40 000 ' . $modelPayment->currency) ?>
                        </div>
                        <div>
                            Получать заявку с Украины
                            <br>
                            <?= Html::checkbox('Payment[tariffs][]', false, [
                                'value' => 'Получать заявку с Украины (год)',
                                'data-price' => 25000
                            ]) . Html::label('25 000 ' . $modelPayment->currency) ?>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div>
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
                                ['class' => 'btn btn-success']
                            ) ?>
                        </div>
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
