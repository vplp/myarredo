<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\forms\models\FormsFeedback;
use frontend\modules\location\models\City;

/**
 * @var $model FormsFeedback
 */

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute(['/forms/forms/feedback'], true),
    'options' => [
        'class' => 'form-inter-phone'
    ]
]); ?>

<?php if (in_array(DOMAIN_TYPE, ['ru', 'ua', 'by'])) {
    $model->city_id = Yii::$app->city->getCityId();
    echo $form
        ->field($model, 'city_id')
        ->dropDownList(
            City::dropDownList(Yii::$app->city->getCountryId()),
            ['class' => 'selectpicker1-search']
        );
} else {
    echo $form
        ->field($model, 'country')
        ->input('text', ['placeholder' => Yii::t('app', 'Country')])
        ->label(false);
} ?>

<?= $form
    ->field($model, 'subject')
    ->dropDownList(
        FormsFeedback::getSubjectRange(),
        ['class' => 'selectpicker1']
    ) ?>

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
    ->input('text', ['placeholder' => Yii::t('app', 'Phone'), 'class' => 'inter-phone form-control'])
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

<?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success big']) ?>

<?php ActiveForm::end();
