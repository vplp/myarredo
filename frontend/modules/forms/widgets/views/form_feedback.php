<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * @var \common\modules\forms\models\FormsFeedback $model
 */

?>

<?= Html::a(
    Yii::t('app', 'Связаться с оператором сайта'),
    'javascript:void(0);',
    [
        'class' => 'btn',
        'data-toggle' => 'modal',
        'data-target' => '#formFeedbackModal'
    ]
) ?>

<div class="modal fade" id="formFeedbackModal">
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

                <?= $form->field($model, 'name')
                    ->input('text', ['placeholder' => Yii::t('app', 'Name')])
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
                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

                <?= $form->field($model, 'reCaptcha')
                    ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())
                    ->label(false) ?>

                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success big']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>