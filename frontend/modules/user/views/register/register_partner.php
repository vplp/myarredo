<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\user\models\form\RegisterForm;
use frontend\modules\location\models\{
    Country, City
};
use borales\extensions\phoneInput\PhoneInput;

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
                        'options' => ['class' => 'form-iti-validate']
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
                                        [null => '--'] + Country::dropDownList([1, 2, 3, 4]) + Country::dropDownListForRegistration(),
                                        ['class' => 'selectpicker rcountry-sct']
                                    );

                                echo $form
                                    ->field($model, 'city_id')
                                    ->dropDownList(
                                        $model->country_id ? [null => '--'] + City::dropDownList($model->country_id) : [null => '--'],
                                        ['class' => 'selectpicker']
                                    );
                                ?>

                                <?= $form->field($model, 'cape_index') ?>

                                <?= $form
                                    ->field($model, 'phone')
                                    ->input('tel', [
                                        'placeholder' => Yii::t('app', 'Phone'),
                                        'class' => 'form-control intlinput-field',
                                        'data-conly' => 'yes'
                                    ])
                                    ->label(false); ?>

                                <?= $form
                                    ->field($model, 'website') ?>

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
                                    ->label('&nbsp;' . Yii::t('app', 'User agreement for partner')) ?>

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
                                    ->widget(\himiklab\yii2\recaptcha\ReCaptcha2::class)
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

console.time('speed register partner js');
var country_id = parseInt($('#registerform-country_id').val());

showHideForItalia(country_id);

$('select#registerform-country_id').change(function(){
    var country_id = parseInt($(this).val());
    
    //changeInputmaskByCountry(country_id);
    
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#registerform-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
    
    showHideForItalia(country_id);
});

function changeInputmaskByCountry(country_id) {
    var inputmask = [];
    
    inputmask[1] = {"clearIncomplete":true,"mask":["+380 (99) 999-99-99"]};
    inputmask[2] = {"clearIncomplete":true,"mask":["+7 (999) 999-99-99"]};
    inputmask[3] = {"clearIncomplete":true,"mask":["+375 (99) 999-99-99"]};
    inputmask[4] = {"clearIncomplete":true,"mask":['+39 (99) 999-999',
    '+39 (999) 999-999',
    '+39 (9999) 999-999',
    '+39 (9999) 999-9999']};
    inputmask[85] = {"clearIncomplete":true,"mask":[""]};

    $('#registerform-phone').inputmask(inputmask[country_id]).trigger('focus').trigger("change");
}

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
        
    } else if (country_id == 85 || country_id == 114 || country_id == 109) {
        
        $('.field-registerform-city_id').css('display', 'none');
        $('.field-registerform-exp_with_italian').css('display', 'none');
        $('.field-registerform-delivery_to_other_cities').css('display', 'none');
        
        $('.field-registerform-cape_index').css('display', 'none');
        
    } else {
        $('.field-registerform-city_id').css('display', 'block');
        $('.field-registerform-exp_with_italian').css('display', 'block');
        $('.field-registerform-delivery_to_other_cities').css('display', 'block');
        
        $('.field-registerform-cape_index').css('display', 'none');
    }
}

// js для отмены события ссылки для бутстрап-селектов в форме регистрации поле - Выбор страны  (для исправления бага в браузерах Firefox)
(function() {
    $('.field-registerform-country_id').on('click', '.bootstrap-select>.dropdown-toggle', function(etg) {
        $(this).siblings('.dropdown-menu').find('a').attr('href', 'javascript:void(0)');
    });
})();

console.timeEnd('speed register partner js');
JS;
$this->registerJs($script);
