<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

$model->user_agreement = 1;
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
    ->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => Yii::$app->city->getPhoneMask(),
        'clientOptions' => [
            'clearIncomplete' => true
        ]
    ])
    ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
    ->label(false) ?>

<?= $form
    ->field($model, 'comment')
    ->textarea(['placeholder' => Yii::t('app', 'Comment')])
    ->label(false) ?>

<?= $form
    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
    ->checkbox([], false)
    ->label('&nbsp;'.$model->getAttributeLabel('user_agreement')) ?>

<?= $form
    ->field($model, 'reCaptcha')
    ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())
    ->label(false) ?>

<?= Html::submitButton(Yii::t('app','Получить лучшую цену'), ['class' => 'add-to-notepad-product btn btn-success big', 'data-id' => $product_id,]) ?>

<?php ActiveForm::end(); ?>