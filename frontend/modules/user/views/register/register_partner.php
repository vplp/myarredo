<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\widgets\recaptcha3\RecaptchaV3Widget;
use frontend\modules\user\models\form\RegisterForm;
use frontend\modules\location\models\{
    Country, City
};

$bundle = AppAsset::register($this);

/** @var $model RegisterForm */

$this->title = Yii::t('app', 'Регистрация для салонов продаж');

$model->delivery_to_other_cities = 1;
$model->user_agreement = 1;
?>

    <main>
        <div class="page sign-up-page">
            <div class="container-wrap">
                <div class="container large-container">
                    <?php $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'action' => Url::toRoute('/user/register/partner'),
                    ]); ?>
                    <div class="row">

                        <div class="col-sm-12 col-md-2">
                            <?= Html::tag('h2', $this->title); ?>
                            <div class="img-cont">
                                <?= Html::img($bundle->baseUrl . '/img/sign-up.svg') ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 right-border">
                            <div class="form-block-in">
                                <?= $form->field($model, 'name_company') ?>

                                <?= $form->field($model, 'address') ?>

                                <?php
                                /**
                                 * country and city
                                 */
                                echo $form->field($model, 'country_id')
                                    ->dropDownList(
                                        [null => '--'] + Country::dropDownList(),
                                        ['class' => 'selectpicker']
                                    );

                                echo $form->field($model, 'city_id')
                                    ->dropDownList(
                                        [null => '--'],
                                        ['class' => 'selectpicker']
                                    );
                                ?>

                                <?= $form->field($model, 'cape_index') ?>

                                <?= $form->field($model, 'phone')
                                    ->widget(\yii\widgets\MaskedInput::class, [
                                        'mask' => Yii::$app->city->getPhoneMask(),
                                        'clientOptions' => [
                                            'clearIncomplete' => true
                                        ]
                                    ]) ?>

                                <?= $form->field($model, 'website') ?>

                                <?= $form->field($model, 'last_name') ?>

                                <?= $form->field($model, 'first_name') ?>

                                <?= $form->field($model, 'email') ?>

                                <?= $form->field($model, 'password')->passwordInput() ?>

                                <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                                <?= $form->field($model, 'exp_with_italian') ?>

                                <?= $form->field($model, 'delivery_to_other_cities')->checkbox() ?>

                                <?= $form
                                    ->field(
                                        $model,
                                        'user_agreement',
                                        ['template' => '{input}{label}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

                                <?= $form
                                    ->field(
                                        $model,
                                        'confirm_processing_data',
                                        ['template' => '{input}{label}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label('&nbsp;' . $model->getAttributeLabel('confirm_processing_data')) ?>

                                <?= $form
                                    ->field($model, 'reCaptcha')
                                    ->widget(
                                        RecaptchaV3Widget::class,
                                        ['actionName' => 'register_partner']
                                    )
                                    ->label(false) ?>

                                <div class="a-warning">
                                    * <?= Yii::t('app', 'Поля обязательны для заполнения') ?>
                                </div>

                                <?= Html::submitButton(
                                    Yii::t('app', 'Зарегистрироваться'),
                                    ['class' => 'btn btn-success']
                                ) ?>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                            <div class="text">
                                <?= Yii::$app->param->getByName('USER_PARTNER_REG_TEXT') ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </main>

<?php
$url = Url::toRoute(['/location/location/get-cities']);
$script = <<<JS
var country_id = parseInt($('#registerform-country_id').val());

showHideForItalia(country_id)

$('select#registerform-country_id').change(function(){
    var country_id = parseInt($(this).val());
    
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#registerform-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
    
   showHideForItalia(country_id)
});

function showHideForItalia(country_id) {
    // if selected Italy
    if (country_id == 4) {
        $('.field-registerform-city_id').css('display', 'none');
        $('.field-registerform-exp_with_italian').css('display', 'none');
        $('.field-registerform-delivery_to_other_cities').css('display', 'none');
        
        $('.field-registerform-cape_index').css('display', 'block');
       
        setTimeout(function() {
            var romeOption = $('select#registerform-city_id').children('option')[1];
            $(romeOption).prop('selected', true);
        },300);
    } else {
        $('.field-registerform-city_id').css('display', 'block');
        $('.field-registerform-exp_with_italian').css('display', 'block');
        $('.field-registerform-delivery_to_other_cities').css('display', 'block');
        
        $('.field-registerform-cape_index').css('display', 'none');
    }
}
JS;

$this->registerJs($script, yii\web\View::POS_READY);
