<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \common\modules\forms\models\FormsFeedback $model
 */

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute(['/forms/forms/feedback'], true)
]); ?>

<?= $form
    ->field($model, 'email')
    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
    ->label(false) ?>

<?= $form
    ->field($model, 'name')
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
    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

<?= $form
    ->field($model, 'reCaptcha')
    ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())
    ->label(false) ?>

<?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success big']) ?>

<?php ActiveForm::end();