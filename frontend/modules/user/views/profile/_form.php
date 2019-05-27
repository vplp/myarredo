<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\{
    Profile, ProfileLang
};
use frontend\modules\sys\models\Language;

/** @var $model Profile */
/** @var $modelLang ProfileLang */

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
                ]); ?>

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
                            <?= $form->field($model, 'website') ?>
                        </div>
                    <?php } ?>

                    <?php
                    /**
                     * for partner
                     */
                    if (Yii::$app->user->identity->group->role == 'partner') { ?>
                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($modelLang, 'name_company') ?>
                            <?= $form->field($model, 'website') ?>
                        </div>

                        <div class="col-md-4 col-lg-4 one-row">
                            <?= $form->field($model, 'country_id')
                                ->dropDownList(
                                    [null => '--'] + Country::dropDownList(),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?= $form->field($model, 'city_id')
                                ->dropDownList(
                                    [null => '--'] + City::dropDownList($model->country_id),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?= $form->field($modelLang, 'address') ?>
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
    inputmask[4] = {"clearIncomplete":true,"mask":["+39 (99) 999-99-99","+39 (9999) 999-999","+39 (9999) 999-9999"]};

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

$this->registerJs($script, yii\web\View::POS_READY);
?>
