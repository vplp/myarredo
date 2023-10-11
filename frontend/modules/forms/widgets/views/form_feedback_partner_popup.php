<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\themes\myarredo\assets\AppAsset;
use forntend\modules\forms\models\FormsFeedback;

/**
 * @var $model FormsFeedback
 * @var $partner_id integer
 */
$bundle = AppAsset::register($this);

$partner = Yii::$app->partner->getPartner();
$city = Yii::$app->city->getCity();

$model->user_agreement = 1;

?>

<div class="modal fade" id="modalFormFeedbackPartner">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?= Yii::t('app', 'Написать салону') ?></h4>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => Url::toRoute(['/forms/forms/feedback-partner'], true),
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>

                <?= $form
                    ->field($model, 'email')
                    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'name')
                    ->input('text', ['placeholder' => Yii::t('app', 'Name')])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'phone')
                    ->input('tel', [
                        'placeholder' => Yii::t('app', 'Phone'),
                        'class' => 'form-control intlinput-field'
                    ])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'comment')
                    ->textarea(['placeholder' => Yii::t('app', 'Comment')])
                    ->label(false); ?>

                <?= $form
                    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
                    ->checkbox([], false)
                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')); ?>

                <?= $form
                    ->field($model, 'partner_id')
                    ->input('hidden', ['value' => $partner_id])
                    ->label(false) ?>

                <?= $form->field($model, 'attachment')->fileInput() ?>

                <?= $form
                    ->field($model, 'reCaptcha')
                    ->widget(\himiklab\yii2\recaptcha\ReCaptcha2::class)
                    ->label(false); ?>

                <?= Html::submitButton(
                    Yii::t('app', 'Отправить'),
                    ['class' => 'btn btn-success big']
                ) ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
