<?php

use kartik\widgets\Select2;
//
use backend\modules\location\models\{
    Country, City
};
use backend\modules\user\models\{
    Profile, ProfileLang
};

/** @var $model Profile */
/** @var $modelLang ProfileLang */

if (in_array($model['user']['group_id'], [4, 7])) {
    echo $form->text_line($model, 'additional_phone');

    echo $form->text_line($model, 'phone');

    echo $form->text_line($modelLang, 'name_company');

    echo $form->text_line($model, 'website');

    echo $form->text_line($model, 'cape_index');
    ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->field($model, 'country_id')
                ->selectOne([0 => '--'] + Country::dropDownList()) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'city_id')
                ->selectOne([0 => '--'] + City::dropDownList($model->country_id)) ?>
        </div>
        <div class="col-md-3">
            <?= $form->text_line($model, 'latitude') ?>
        </div>
        <div class="col-md-3">
            <?= $form->text_line($model, 'longitude') ?>
        </div>
    </div>

    <?php
    echo $form->text_line($modelLang, 'address');
    echo $form->text_line($modelLang, 'address2');

    echo $form
        ->field($model, 'city_ids')
        ->widget(Select2::class, [
            'data' => City::dropDownList($model->country_id),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);

    echo $form->switcher($model, 'partner_in_city');

    echo $form->switcher($model, 'partner_in_city_paid');

    echo $form->switcher($model, 'possibility_to_answer');

    echo $form->switcher($model, 'pdf_access');

    echo $form->switcher($model, 'show_contacts');

    echo $form->switcher($model, 'show_contacts_on_sale');

    echo $form->switcher($model, 'answers_per_month');

    echo $form
        ->field($model, 'image_link')
        ->label('Фото салона')
        ->imageOne($model->getImageLink());
}

$url = \yii\helpers\Url::toRoute('/location/city/get-cities');

$script = <<<JS
$('select#profile-country_id').change(function(){
    var country_id = parseInt($(this).val());
    $.post('$url', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#profile-city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
});

JS;

$this->registerJs($script);