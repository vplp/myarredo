<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => Url::toRoute('/shop/cart/notepad'),
    'id' => 'checkout-form',
]); ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Заполните форму - получите лучшую цену на этот товар</h4>
    </div>
    <div class="modal-body">

        <?= $form
            ->field($model, 'email')
            ->input('text', ['placeholder' => Yii::t('app', 'Email')])
            ->label(false) ?>

        <?= $form->field($model, 'full_name')
            ->input('text', ['placeholder' => Yii::t('app', 'Full name')])
            ->label(false) ?>

        <?= $form->field($model, 'phone')
            ->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => Yii::$app->city->getPhoneMask(),
                'clientOptions' => [
                    'clearIncomplete' => true
                ]
            ])
            ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
            ->label(false) ?>

        <?= $form->field($model, 'comment')
            ->textarea(['placeholder' => Yii::t('app', 'Comment')])
            ->label(false) ?>

        <?= $form->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])->checkbox([], false)
            ->label('&nbsp;'.$model->getAttributeLabel('user_agreement')) ?>

    </div>
    <div class="modal-footer">
        <?= Html::submitButton('Получить лучшую цену', ['class' => 'btn btn-success big']) ?>
    </div>

<?php ActiveForm::end(); ?>