<?php

use backend\app\bootstrap\ActiveForm;
use yii\helpers\{
    Html, Url
};
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\Factory;
use frontend\modules\user\models\{
    Profile, ProfileLang
};
use frontend\modules\sys\models\Language;

/** @var $model Profile */
/** @var $modelLang ProfileLang */
/** @var $modelFactory Factory */

$this->title = Yii::t('app', 'Profile');

?>

<main>
    <div class="page factory-profile">
        <div class="largex-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact part-contact-update">

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/user/profile/update']),
                    'options' => ['class' => 'user-update-form']
                ]) ?>

                <div class="row">

                    <div class="col-md-4 col-lg-4 one-row">
                        <?= $form->field($model, 'first_name') ?>
                        <?= $form->field($model, 'last_name') ?>

                        <?= $form->field($model, 'phone')
                            ->widget(\yii\widgets\MaskedInput::class, [
                                'mask' => $model->country_id
                                    ? Yii::$app->city->getPhoneMask($model->country->alias)
                                    : Yii::$app->city->getPhoneMask(),
                                'clientOptions' => [
                                    'clearIncomplete' => true
                                ]
                            ]) ?>

                        <?php if (Yii::$app->user->identity->group->role == 'partner' && $model->partner_in_city) {
                            echo $form->field($model, 'phone2')
                                ->widget(\yii\widgets\MaskedInput::class, [
                                    'mask' => $model->country_id
                                        ? Yii::$app->city->getPhoneMask($model->country->alias)
                                        : Yii::$app->city->getPhoneMask(),
                                    'clientOptions' => [
                                        'clearIncomplete' => true
                                    ]
                                ]);
                        } ?>

                        <?= $form->field($model, 'preferred_language')
                            ->dropDownList(
                                Language::dropDownList(),
                                ['class' => 'selectpicker']
                            ) ?>

                    </div>

                    <?php
                    /**
                     * for factory
                     */
                    if (Yii::$app->user->identity->group->role == 'factory') { ?>
                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($model, 'email_company') ?>
                            <?= $form->field($modelLang, 'address') ?>
                            <?= $form
                                ->field($model, 'website')
                                ->widget(\yii\widgets\MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'url',
                                    ],
                                ]) ?>
                        </div>

                        <?php if ($modelFactory) { ?>
                            <div class="col-md-4 col-lg-4 one-row">
                                <?= $form
                                    ->field($modelFactory, 'image_link')
                                    ->label(Yii::t('app', 'Логотип'))
                                    ->imageOne($modelFactory->getImageLink()) ?>
                            </div>
                        <?php } ?>

                    <?php } ?>

                    <?php
                    /**
                     * for partner
                     */
                    if (Yii::$app->user->identity->group->role == 'partner') { ?>
                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($modelLang, 'name_company') ?>
                            <?= $form
                                ->field($model, 'country_id')
                                ->dropDownList(
                                    [null => '--'] + Country::dropDownList([1, 2, 3, 4]),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?= $form
                                ->field($model, 'city_id')
                                ->dropDownList(
                                    [null => '--'] + City::dropDownList($model->country_id),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?= $form->field($modelLang, 'address') ?>
                            <?= $form->field($model, 'working_hours_start') ?>
                            <?= $form->field($model, 'working_hours_end') ?>

                            <?php if ($model->partner_in_city) {
                                echo $form->field($modelLang, 'address2');
                                echo $form->field($model, 'working_hours_start');
                                echo $form->field($model, 'working_hours_end');
                            } ?>

                            <?= $form
                                ->field($model, 'website')
                                ->widget(\yii\widgets\MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'url',
                                    ],
                                ]) ?>
                        </div>

                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form
                                ->field($model, 'image_salon')
                                ->label(Yii::t('app', 'Фото салона') . ' (1070х800 px)')
                                ->imageOne($model->getImageLink('image_salon')) ?>
                        </div>
                    <?php } ?>

                    <?php
                    /**
                     * for logistician
                     */
                    if (Yii::$app->user->identity->group->role == 'logistician') { ?>
                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($modelLang, 'name_company') ?>
                            <?= $form
                                ->field($model, 'country_id')
                                ->dropDownList(
                                    [null => '--'] + Country::dropDownList([1, 2, 3, 4]),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?= $form
                                ->field($model, 'city_id')
                                ->dropDownList(
                                    [null => '--'] + City::dropDownList($model->country_id),
                                    ['class' => 'selectpicker']
                                ) ?>
                            <?= $form->field($modelLang, 'address') ?>

                            <?= $form
                                ->field($model, 'website')
                                ->widget(\yii\widgets\MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'url',
                                    ],
                                ]) ?>

                            <?= $form->field($modelLang, 'about_company')->textarea(['rows' => 10]) ?>
                        </div>

                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form
                                ->field($model, 'image_link')
                                ->label(Yii::t('app', 'Логотип'))
                                ->imageOne($model->getImageLink()) ?>
                        </div>
                    <?php } ?>

                </div>

                <div class="row form-group">
                    <div class="col-sm-4">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>

                        <?= Html::a(Yii::t('app', 'Cancel'), ['/user/profile/index'], ['class' => 'btn btn-primary']) ?>
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
var country_id = parseInt($('#profile-country_id').val());

showHideForItalia(country_id);

$('select#profile-country_id').change(function(){
    var country_id = parseInt($(this).val());
    
    changeInputmaskByCountry(country_id);
    showHideForItalia(country_id);
    
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#profile-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});

function showHideForItalia(country_id) {
    // if selected Italy
    if (country_id == 4) {
        $('.field-profile-city_id').css('display', 'none');
        
        setTimeout(function() {
            var romeOption = $('select#registerform-city_id').children('option')[0];
            $(romeOption).prop('selected', true);
        },300);
    } else {
        $('.field-profile-city_id').css('display', 'block');
    }
}

function changeInputmaskByCountry(country_id) {
    
    var inputmask = [];
    
    inputmask[1] = {"clearIncomplete":true,"mask":["+380 (99) 999-99-99"]};
    inputmask[2] = {"clearIncomplete":true,"mask":["+7 (999) 999-99-99"]};
    inputmask[3] = {"clearIncomplete":true,"mask":["+375 (99) 999-99-99"]};
    inputmask[4] = {"clearIncomplete":true,"mask":['+39 (99) 999-999',
                '+39 (999) 999-999',
                '+39 (9999) 999-999',
                '+39 (9999) 999-9999']};

    var mask;
    
    if (!isNaN(country_id) && country_id != '') {
        mask = inputmask[country_id];
    } else {
        mask = inputmask[4];
    }
    console.log(mask)
    $('#profile-phone').inputmask(mask).trigger('focus').trigger("change");
}
JS;

$this->registerJs($script);
?>
