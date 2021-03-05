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

$image_link = isset($partner['profile']['image_link'])
    ? $partner['profile']['imageLink']
    : $bundle->baseUrl . '/img/cont-photo-bg.jpg';

$model->user_agreement = 1;

?>

<div class="cont-info feedback-container">
    <div class="cont-info-in feedback-box">
        <div class="cont-info-border">
            <div class="feedback-title"><?= Yii::t('app', 'Связаться с салоном'); ?></div>

            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => Url::toRoute(['/forms/forms/feedback-partner'], true)
            ]); ?>
            
            <div class="leftbox">
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
                    ->widget(\yii\widgets\MaskedInput::class, [
                        'mask' => Yii::$app->city->getPhoneMask(),
                        'clientOptions' => [
                            'clearIncomplete' => true
                        ]
                    ])
                    ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
                    ->label(false); ?>
            </div>

            <div class="rightbox">
            <?= $form
                ->field($model, 'comment')
                ->textarea(['placeholder' => Yii::t('app', 'Comment')])
                ->label(false); ?>
            </div>

            <div class="bottombox">
                <?= $form
                    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
                    ->checkbox([], false)
                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')); ?>

                <?= $form
                    ->field($model, 'partner_id')
                    ->input('hidden', ['value' => $partner_id])
                    ->label(false) ?>

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

<div class="cont-bg custom-lazy" data-background="<?= $image_link ?>"></div>
