<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\catalog\models\SaleRequest;

/** @var $model SaleRequest */

$model->user_agreement = 1;

?>

<div class="modal fade" id="modalSaleRequestForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?= Yii::t('app', 'Заполните форму') ?></h4>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => false
                ]); ?>

                <?= $form
                    ->field($model, 'email')
                    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
                    ->label(false) ?>

                <?= $form
                    ->field($model, 'user_name')
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

                <?= $form
                    ->field($model, 'question')
                    ->textarea(['placeholder' => Yii::t('app', 'Comment')])
                    ->label(false) ?>

                <?= $form
                    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
                    ->checkbox([], false)
                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

                <?= $form
                    ->field($model, 'reCaptcha')
                    ->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha2::class
                    )
                    ->label(false) ?>

                <?= Html::submitButton(
                    Yii::t('app', 'Отправить'),
                    ['class' => 'btn btn-success big']
                ) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
