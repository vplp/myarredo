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

<div>
    <div class="row">
        <div class="col-sm-12 col-md-4"></div>
        <div class="col-sm-12 col-md-4">

            <h3 class="feedback-title"><?= Yii::t('app', 'Хотите стать нашим партнером? Оправте заявку'); ?>:</h3>

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
                    ->input('tel', [
                        'placeholder' => Yii::t('app', 'Phone'),
                        'class' => 'form-control intlinput-field2'
                    ])
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
        <div class="col-sm-12 col-md-4"></div>
    </div>
</div>
