<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\forms\models\FormsFeedback;

/**
 * @var $model FormsFeedback
 * @var $partner_id integer
 */

$model->user_agreement = 1;

?>

<div class="container large-container">
    <div class="row">
        <div class="col-sm-6 col-md-6">

            <div class="feedback-title"><?= Yii::t('app', 'Хотите стать нашим партнером? Оправте заявку'); ?>:</div>

            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => Url::toRoute(['/forms/forms/feedback'], true)
            ]); ?>

            <div class="leftbox">

                <?= $form
                    ->field($model, 'name')
                    ->input('text', ['placeholder' => Yii::t('app', 'Name')])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'comment')
                    ->input('text', ['placeholder' => Yii::t('app', 'Company')])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'email')
                    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'phone')
                    ->widget(\yii\widgets\MaskedInput::class, [
                        'mask' => Yii::$app->city->getPhoneMask(),
                        'clientOptions' => [
                            'clearIncomplete' => true
                        ]
                    ])
                    ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
                    ->label(false); ?>
            </div>

            <div class="bottombox">
                <?= $form
                    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
                    ->checkbox([], false)
                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')); ?>

                <?= $form
                    ->field($model, 'reCaptcha')
                    ->widget(\himiklab\yii2\recaptcha\ReCaptcha2::class)
                    ->label(false); ?>
            </div>
            <div class="bottom-panel">
                <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn btn-success big']); ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
