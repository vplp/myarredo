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
use frontend\modules\catalog\models\FactorySubdivision;

$bundle = AppAsset::register($this);

/**
 * @var $model RegisterForm
 * @var $modelFactorySubdivision FactorySubdivision
 */

$this->title = Yii::t('app', 'Регистрация для фабрики');

$model->user_agreement = 1;
$model->factory_confirm_offers = 1;
?>

    <main>
        <div class="page sign-up-page">
            <div class="container-wrap">
                <div class="container large-container">
                    <?php $form = ActiveForm::begin([
                        'id' => 'register-form',
                        'action' => Url::toRoute('/user/register/factory'),
                        'options' => ['class' => 'form-iti-validate']
                    ]); ?>
                    <div class="row">

                        <div class="col-sm-12 col-md-2">
                            <?= Html::tag('h2', $this->title); ?>
                            <div class="img-cont">
                                <?= Html::img($bundle->baseUrl . '/img/sign-up-2.svg') ?>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 right-border">
                            <div class="form-block-in">

                                <?= $form->field($model, 'name_company') ?>

                                <?= $form->field($model, 'address') ?>

                                <?= $form
                                    ->field($model, 'country_id')
                                    ->dropDownList(
                                        [null => '--'] + Country::dropDownListForRegistration(),
                                        [
                                            'class' => 'selectpicker rcountry-sct'
                                        ]
                                    ) ?>

                                <?= $form
                                    ->field($model, 'city_id')
                                    ->input('hidden', ['value' => 0])
                                    ->label(false) ?>

                                <?= $form
                                    ->field($model, 'phone')
                                    ->input('tel', [
                                        'placeholder' => Yii::t('app', 'Phone'),
                                        'class' => 'form-control intlinput-field',
                                        'data-conly' => 'yes'
                                    ])
                                    ->label(false); ?>

                                <?= $form->field($model, 'website') ?>

                                <?= $form->field($model, 'last_name') ?>

                                <?= $form->field($model, 'first_name') ?>

                                <?= $form->field($model, 'email') ?>

                                <?= $form
                                    ->field(
                                        $modelFactorySubdivision,
                                        'subdivision_in_cis',
                                        ['template' => '{label}{input}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label($modelFactorySubdivision->getAttributeLabel('subdivision_in_cis') . '&nbsp;') ?>

                                <div class="subdivision_in_cis" style="display: none">
                                    <?= $form->field($modelFactorySubdivision, 'company_name') ?>
                                    <?= $form->field($modelFactorySubdivision, 'contact_person') ?>
                                    <?= $form->field($modelFactorySubdivision, 'email') ?>
                                    <?= $form->field($modelFactorySubdivision, 'phone') ?>
                                </div>

                                <?= $form
                                    ->field(
                                        $modelFactorySubdivision,
                                        'subdivision_in_italy',
                                        ['template' => '{label}{input}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label($modelFactorySubdivision->getAttributeLabel('subdivision_in_italy') . '&nbsp;') ?>

                                <div class="subdivision_in_italy" style="display: none">
                                    <?= $form->field($modelFactorySubdivision, 'company_name') ?>
                                    <?= $form->field($modelFactorySubdivision, 'contact_person') ?>
                                    <?= $form->field($modelFactorySubdivision, 'email') ?>
                                    <?= $form->field($modelFactorySubdivision, '[1]phone') ?>
                                </div>

                                <?= $form
                                    ->field(
                                        $modelFactorySubdivision,
                                        'subdivision_in_europe',
                                        ['template' => '{label}{input}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label($modelFactorySubdivision->getAttributeLabel('subdivision_in_europe') . '&nbsp;') ?>

                                <div class="subdivision_in_europe" style="display: none">
                                    <?= $form->field($modelFactorySubdivision, '[2]company_name') ?>
                                    <?= $form->field($modelFactorySubdivision, '[2]contact_person') ?>
                                    <?= $form->field($modelFactorySubdivision, '[2]email') ?>
                                    <?= $form->field($modelFactorySubdivision, '[2]phone') ?>
                                </div>

                                <?= $form->field($model, 'password')->passwordInput() ?>

                                <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                                <?= $form
                                    ->field(
                                        $model,
                                        'user_agreement',
                                        ['template' => '{input}{label}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label('&nbsp;' . Yii::t('app', 'User agreement for factory')) ?>

                                <?= $form
                                    ->field(
                                        $model,
                                        'factory_confirm_offers',
                                        ['template' => '{input}{label}{error}{hint}']
                                    )
                                    ->checkbox([], false)
                                    ->label('&nbsp;' . $model->getAttributeLabel('factory_confirm_offers')) ?>


                                <?= $form
                                    ->field($model, 'reCaptcha')
                                    ->widget(
                                        \himiklab\yii2\recaptcha\ReCaptcha2::class
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
$script = <<<JS
$('input[name="FactorySubdivision[subdivision_in_cis]"]').on('change', function () {
    if($(this).is(":checked")) {
        console.log("Checkbox is checked.");
        $('.subdivision_in_cis').show();
    }
    else if ($(this).is(":not(:checked)")) {
        console.log("Checkbox is unchecked.");
        $('.subdivision_in_cis').hide();
    }
});
$('input[name="FactorySubdivision[subdivision_in_italy]"]').on('change', function () {
    if ($(this).is(":checked")) {
        console.log("Checkbox is checked.");
        $('.subdivision_in_italy').show();
    }
    else if ($(this).is(":not(:checked)")) {
        console.log("Checkbox is unchecked.");
        $('.subdivision_in_italy').hide();
    }
});
$('input[name="FactorySubdivision[subdivision_in_europe]"]').on('change', function () {
    if ($(this).is(":checked")) {
        console.log("Checkbox is checked.");
        $('.subdivision_in_europe').show();
    }
    else if ($(this).is(":not(:checked)")) {
        console.log("Checkbox is unchecked.");
        $('.subdivision_in_europe').hide();
    }
});
JS;

$this->registerJs($script);
