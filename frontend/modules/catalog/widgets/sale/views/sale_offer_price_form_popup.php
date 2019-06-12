<?php

use yii\helpers\{
    Html, Url
};
use yii\web\View;
use yii\widgets\ActiveForm;
//
use frontend\modules\catalog\models\SaleRequest;

/** @var $model SaleRequest */

?>

    <div class="modal fade" id="modalSaleOfferPrice">
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
                        ->input('text', ['id' => 'salerequest-offerprice-phone', 'placeholder' => Yii::t('app', 'Phone')])
                        ->label(false) ?>

                    <?= $form
                        ->field($model, 'offer_price')
                        ->input('text', ['placeholder' => Yii::t('app', 'Price')])
                        ->label(false) ?>

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

<?php
$url = Url::toRoute(['/location/location/get-cities']);
$country_id = Yii::$app->city->getCountryId();
$script = <<<JS
var country_id = $country_id;
var inputmask = [];

inputmask[1] = {"clearIncomplete":true,"mask":["+380 (99) 999-99-99"]};
inputmask[2] = {"clearIncomplete":true,"mask":["+7 (999) 999-99-99"]};
inputmask[3] = {"clearIncomplete":true,"mask":["+375 (99) 999-99-99"]};
inputmask[4] = {"clearIncomplete":true,"mask":["+39 (99) 999-99-99","+39 (9999) 999-999","+39 (9999) 999-9999"]};
    
$('#salerequest-offerprice-phone').inputmask(inputmask[country_id]).trigger('focus').trigger("change");
JS;

$this->registerJs($script, yii\web\View::POS_READY);