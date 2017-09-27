<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\{
    DeliveryMethods, PaymentMethods
};

$this->context->breadcrumbs[] = [
    'label' => $this->context->label
];

?>

<div class="checkout-page page">
    <div class="cont">
        <div class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'homeLink' => [
                    'label' => Yii::t('yii', 'Home'),
                    'url' => \yii\helpers\Url::toRoute(['/home/home/index'])
                ],
                'links' => $this->context->breadcrumbs
            ]) ?>
        </div>

        <?= Html::tag('h2', $this->context->label) ?>

        <div class="checkout-in">
            <div class="check-form-cont">

                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => Url::toRoute('/shop/cart/checkout'),
                    'options' => [],
                    'id' => 'checkout-form'
                ]); ?>

                <div class="check-form-in flex">
                    <div class="left">
                        <div class="title">
                            Личные данные:
                        </div>

                        <?= $form
                            ->field($model, 'full_name')
                            ->input('text', ['placeholder' => Yii::t('app', 'Full name')])
                            ->label(false) ?>

                        <?= $form
                            ->field($model, 'email')
                            ->input('text', ['placeholder' => Yii::t('app', 'Email')])
                            ->label(false) ?>

                        <?= $form
                            ->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '380999999999',
                                'clientOptions' => [
                                    'clearIncomplete' => true
                                ]
                            ])
                            ->input(
                                'text',
                                [
                                    'placeholder' => Yii::t('app', 'Phone'),
                                    'class' => 'input'
                                ]
                            )
                            ->label(false) ?>

                        <div class="flex two-ar">
                            <div class="form-group">
                                <select data-styler-select>
                                    <option disabled selected>Область</option>
                                    <option>Киевская</option>
                                    <option>Харьковская</option>
                                    <option>Львовская</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="" placeholder="Город">
                                <div class="help-block"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" class="" placeholder="Адрес">
                            <div class="help-block"></div>
                        </div>

                        <?= $form
                            ->field($model, 'delivery')
                            ->dropDownList(
                                ['' => Yii::t('app', 'Delivery method')] + DeliveryMethods::dropDownList(),
                                ['class' => '', 'data-styler-select' => true]
                            )
                            ->label(false) ?>

                        <?= $form
                            ->field($model, 'pay')
                            ->dropDownList(
                                ['' => Yii::t('app', 'Payment method')] + PaymentMethods::dropDownList(),
                                ['class' => '', 'data-styler-select' => true]
                            )
                            ->label(false) ?>

                        <div class="form-group">
                            <div class="title">
                                Желаемая дата и время доставки:
                            </div>
                            <div class="flex-row">
                                        <span>
                                            Дата:
                                        </span>
                                <div class="form-group">
                                    <input type="text" placeholder="День">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="Месяц">
                                </div>
                            </div>
                            <div class="flex-row time">
                                        <span>
                                            Время:
                                        </span>
                                <div class="form-group">
                                    <span class="before"> От</span><input type="text" placeholder="00:00">
                                </div>
                                <div class="form-group">
                                    <span class="before">До</span><input type="text" placeholder="00:00">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="right">

                        <?= \frontend\modules\shop\widgets\cart\Cart::widget(['view' => 'full_checkout']) ?>

                        <div class="control-buttons flex s-between">
                            <?= Html::a('Редактировать корзину', ['/shop/cart/index'], ['class' => 'std-but std-but-empty']) ?>
                            <?= Html::submitButton('Оформить заказ', ['class' => 'std-but']) ?>
                        </div>

                    </div>

                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>