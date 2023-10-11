<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
//
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\form\RegisterForm;

$bundle = AppAsset::register($this);

/**
 * @var $model RegisterForm
 */

$this->title = Yii::t('app', 'Регистрация для логиста');

$model->user_agreement = 1;
$model->user_confirm_offers = 1;
?>

    <main>
        <div class="page sign-up-page">
            <div class="container-wrap">
                <div class="container large-container">
                    <?php $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'action' => Url::toRoute('/user/register/logistician'),
                        'options' => ['class' => 'form-iti-validate']
                    ]); ?>
                    <div class="row">

                        <div class="col-sm-12 col-md-2">
                            <?= Html::tag('h2', $this->title); ?>
                            <div class="img-cont">
                                <?= Html::img($bundle->baseUrl . '/img/sign-up-3.svg') ?>
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
                                echo $form
                                    ->field($model, 'country_id')
                                    ->dropDownList(
                                        [null => '--'] + Country::dropDownList([1, 2, 3]),
                                        ['class' => 'selectpicker']
                                    );

                                echo $form
                                    ->field($model, 'city_id')
                                    ->dropDownList(
                                        $model->country_id ? [null => '--'] + City::dropDownList($model->country_id) : [null => '--'],
                                        ['class' => 'selectpicker']
                                    );
                                ?>

                                <?= $form
                                    ->field($model, 'phone')
                                    ->widget(\yii\widgets\MaskedInput::class, [
                                        'mask' => Yii::$app->city->getPhoneMask(),
                                        'clientOptions' => [
                                            'clearIncomplete' => true
                                        ]
                                    ]) ?>

                                <?= $form
                                    ->field($model, 'website') ?>

                                <?= $form->field($model, 'last_name') ?>

                                <?= $form->field($model, 'first_name') ?>

                                <?= $form->field($model, 'email') ?>

                                <?= $form->field($model, 'password')->passwordInput() ?>

                                <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                                <?= $form
                                    ->field(
                                        $model,
                                        'user_agreement',
                                        ['template' => '{input}{label}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label('&nbsp;' . Yii::t('app', 'User agreement for logistician')) ?>

                                <?= $form
                                    ->field(
                                        $model,
                                        'user_confirm_offers',
                                        ['template' => '{input}{label}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label('&nbsp;' . $model->getAttributeLabel('user_confirm_offers')) ?>

                                <?= $form
                                    ->field($model, 'reCaptcha')
                                    ->widget(
                                        \himiklab\yii2\recaptcha\ReCaptcha2::class
                                    //['action' => 'register_factory']
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
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </main>


<?php
$url = Url::toRoute(['/location/location/get-cities']);
$script = <<<JS
$('select#registerform-country_id').change(function(){
    var country_id = parseInt($(this).val());
    
    changeInputmaskByCountry(country_id);
    
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#registerform-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
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

    $('#registerform-phone').inputmask(inputmask[country_id]).trigger('focus').trigger("change");
}
JS;

$this->registerJs($script);
