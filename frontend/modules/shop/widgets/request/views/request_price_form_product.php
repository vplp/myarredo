<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('/shop/cart/index'),
    'id' => 'checkout-form',
]); ?>

<?= $form
    ->field($model, 'email')
    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
    ->label(false) ?>

<?= $form->field($model, 'full_name')
    ->input('text', ['placeholder' => Yii::t('app', 'Full name')])
    ->label(false) ?>

<?= $form->field($model, 'phone')
    ->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '79999999999',
        'clientOptions' => [
            'clearIncomplete' => true
        ]
    ])
    ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
    ->label(false) ?>

<?= $form->field($model, 'comment')
    ->textarea(['placeholder' => Yii::t('app', 'Comment')])
    ->label(false) ?>

<?= Html::submitButton('Получить лучшую цену', ['class' => 'add-to-notepad-product btn btn-success big', 'data-id' => $product_id,]) ?>

<?php ActiveForm::end(); ?>