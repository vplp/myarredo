<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\CartCustomerForm;

/** @var $model CartCustomerForm */
/** @var $product_id */

$model->user_agreement = 1;

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('/shop/cart/notepad'),
    'id' => 'checkout-form',
    'options' => ['class' => 'form-iti-validate']
]); ?>

<?= $form
    ->field($model, 'email')
    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
    ->label(false) ?>

<?= $form
    ->field($model, 'full_name')
    ->input('text', ['placeholder' => Yii::t('app', 'Name')])
    ->label(false) ?>

<?php if (in_array(DOMAIN_TYPE, ['com', 'de', 'kz', 'co.il'])) {
    $model->city_id = 0;
    $model->country_code = Yii::$app->city->getCountryCode();

    echo $form
        ->field($model, 'phone')
        ->input('tel', [
            'placeholder' => Yii::t('app', 'Phone'),
            'class' => 'form-control intlinput-field'
        ])
        ->label(false);
} else {
    $model->city_id = Yii::$app->city->getCityId();
    $model->country_code = Yii::$app->city->getCountryCode();

    echo $form
        ->field($model, 'phone')
        ->widget(\yii\widgets\MaskedInput::class, [
            'mask' => Yii::$app->city->getPhoneMask(),
            'clientOptions' => [
                'clearIncomplete' => true
            ]
        ])
        ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
        ->label(false);
} ?>

<?= $form
    ->field($model, 'country_code')
    ->input('hidden', ['value' => $model->country_code])
    ->label(false) ?>

<?= $form
    ->field($model, 'city_id')
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
    ->widget(\himiklab\yii2\recaptcha\ReCaptcha2::class)
    ->label(false) ?>

<?= Html::submitButton(
    Yii::t('app', 'Получить лучшую цену'),
    [
        'class' => 'add-to-notepad-product btn btn-success big',
        'data-id' => $product_id,
    ]
) ?>

<?php ActiveForm::end();
