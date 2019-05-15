<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\shop\models\CartCustomerForm;

/** @var $model CartCustomerForm */

$model->user_agreement = 1;
$model->city_id = Yii::$app->city->getCityId();
?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('/shop/cart/notepad'),
    'id' => 'checkout-form',
]); ?>

<?= $form
    ->field($model, 'email')
    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
    ->label(false) ?>

<?= $form
    ->field($model, 'full_name')
    ->input('text', ['placeholder' => Yii::t('app', 'Name')])
    ->label(false) ?>

<?= $form
    ->field($model, 'phone')
    ->widget(\yii\widgets\MaskedInput::class, [
        'mask' => Yii::$app->city->getPhoneMask(),
        'clientOptions' => [
            'clearIncomplete' => true
        ]
    ])
    ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
    ->label(false) ?>

<?= $form->field($model, 'city_id')
    ->input('hidden', ['value' => $model->city_id])
    ->label(false) ?>

<?= $form
    ->field($model, 'comment')
    ->textarea(['placeholder' => Yii::t('app', 'Comment')])
    ->label(false) ?>

<?= $form
    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
    ->checkbox([], false)
    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

<?= $form
    ->field($model, 'reCaptcha')
    ->widget(
        \frontend\widgets\recaptcha3\RecaptchaV3Widget::class,
        ['actionName' => 'request_price_product']
    )
    ->label(false) ?>

<?= Html::submitButton(
    Yii::$app->controller->id == 'sale-italy'
        ? Yii::t('app', 'Узнай цену на доставку')
        : Yii::t('app', 'Получить лучшую цену'),
    [
        'class' => 'add-to-notepad-product btn btn-success big',
        'data-id' => $product_id,
    ]
) ?>

<?php ActiveForm::end();