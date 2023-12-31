<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\modules\shop\models\FormFindProduct;

/** @var $model FormFindProduct */

$model->user_agreement = 1;

?>

<?= Html::a(
    Yii::t('app', 'Не нашли то что искали? Оставьте заявку тут'),
    'javascript:void(0);',
    [
        'class' => 'btn btn-showmore',
        'data-toggle' => 'modal',
        'data-target' => '#formRequestNotFoundModal'
    ]
) ?>


<div class="modal fade" id="formRequestNotFoundModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title"><?= Yii::t('app', 'Не нашли то что искали? Оставьте заявку тут') ?></h3>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => Url::toRoute('/shop/cart/request-find-product'),
                    'options' => [
                        'enctype' => 'multipart/form-data'
                    ]
                ]); ?>

                <?= $form
                    ->field($model, 'email')
                    ->input('text', ['placeholder' => Yii::t('app', 'Email')])
                    ->label(false) ?>

                <?= $form
                    ->field($model, 'full_name')
                    ->input('text', ['placeholder' => Yii::t('app', 'Name')])
                    ->label(false) ?>

                <?php if (in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'uk', 'kz', 'co.il'])) {
                    $model->city_id = 0;
                    $model->country_code = Yii::$app->city->getCountryCode();

                    echo $form
                        ->field($model, 'phone')
                        ->input('tel', [
                            'placeholder' => Yii::t('app', 'Phone'),
                            'class' => 'form-control intlinput-field2'
                        ])
                        ->label(false);
                } else {
                    $model->city_id = Yii::$app->city->getCityId();
                    $model->country_code = Yii::$app->city->getCountryCode();

                    echo $form
                        ->field($model, 'phone')
                        ->widget(\yii\widgets\MaskedInput::class, [
                            'mask' => Yii::$app->city->getPhoneMask(),
                            'clientOptions' => [
                                'clearIncomplete' => true
                            ]
                        ])
                        ->input('text', ['placeholder' => Yii::t('app', 'Phone')])
                        ->label(false);
                } ?>

                <?= $form
                    ->field($model, 'country_code')
                    ->input('hidden', ['value' => $model->country_code])
                    ->label(false) ?>

                <?= $form
                    ->field($model, 'city_id')
                    ->input('hidden', ['value' => $model->city_id])
                    ->label(false) ?>

                <?= $form
                    ->field($model, 'comment')
                    ->textarea(['placeholder' => Yii::t('app', 'Comment')])
                    ->label(false) ?>

                <?= $form
                    ->field($model, 'image_link')
                    ->fileInput() ?>

                <?= $form
                    ->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])
                    ->checkbox([], false)
                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

                <?= $form
                    ->field($model, 'reCaptcha')
                    ->widget(\himiklab\yii2\recaptcha\ReCaptcha2::class)
                    ->label(false) ?>

                <?= Html::submitButton(
                    Yii::t('app', 'Отправить'),
                    [
                        'class' => 'btn btn-success big',
                    ]
                ) ?>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>


