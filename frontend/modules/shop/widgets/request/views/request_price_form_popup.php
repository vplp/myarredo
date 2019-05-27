<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\modules\location\models\City;

/** @var $model \frontend\modules\shop\models\CartCustomerForm */

$model->user_agreement = 1;
$model->city_id = Yii::$app->city->getCityId();

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('/shop/cart/notepad'),
    'id' => 'checkout-form',
]); ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"
            id="myModalLabel"><?= Yii::t('app', 'Заполните форму - получите лучшую цену на этот товар') ?></h4>
    </div>
    <div class="modal-body">

        <?= $form
            ->field($model, 'email')
            ->input('text', ['placeholder' => Yii::t('app', 'Email')])
            ->label(false) ?>

        <?= $form->field($model, 'full_name')
            ->input('text', ['placeholder' => Yii::t('app', 'Name')])
            ->label(false) ?>

        <?= $form->field($model, 'phone')
            ->widget(\yii\widgets\MaskedInput::class, [
                'mask' => Yii::$app->city->getPhoneMask(),
                'clientOptions' => [
                    'clearIncomplete' => true
                ]
            ])
            ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
            ->label(false) ?>

        <?php
        //        $form->field($model, 'city_id')
        //            ->dropDownList(City::dropDownList(Yii::$app->city->getCountryId()))
        //            ->label(false)
        ?>

        <?= $form->field($model, 'city_id')
            ->input('hidden', ['value' => $model->city_id])
            ->label(false) ?>

        <?= $form->field($model, 'comment')
            ->textarea(['placeholder' => Yii::t('app', 'Comment')])
            ->label(false) ?>

        <?= $form->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])->checkbox([], false)
            ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

        <?= $form
            ->field($model, 'reCaptcha')
            ->widget(
                \himiklab\yii2\recaptcha\ReCaptcha2::class
                //['action' => 'request_price_popup']
            )
            ->label(false) ?>

    </div>
    <div class="modal-footer">
        <?= Html::submitButton(
            Yii::t('app', 'Получить лучшую цену'),
            ['class' => 'btn btn-success big']
        ) ?>
    </div>

<?php ActiveForm::end(); ?>