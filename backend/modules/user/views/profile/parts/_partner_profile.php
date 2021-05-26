<?php

use kartik\widgets\Select2;
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
    echo $form->text_line($model, 'phone2');

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
    </div>

    <div class="row control-group">
        <div class="col-md-4">
            <?= $form->text_line($modelLang, 'address') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'latitude') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'longitude') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'working_hours_start') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'working_hours_end') ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-4">
            <?= $form->text_line($modelLang, 'address2') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'latitude2') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'longitude2') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'working_hours_start2') ?>
        </div>
        <div class="col-md-2">
            <?= $form->text_line($model, 'working_hours_end2') ?>
        </div>
    </div>

    <?php
    echo $form
        ->field($model, 'country_ids')
        ->label(Yii::t('app', 'Ответ на заявку из страны'))
        ->widget(Select2::class, [
            'data' => Country::dropDownList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);

    foreach (Country::dropDownList([1, 2, 3, 4]) as $id => $name) {
        echo $form
            ->field($model, 'country_cities_' . $id)
            ->label(Yii::t('app', 'Ответы в городах') . ' (' . $name . ')')
            ->widget(Select2::class, [
                'data' => City::dropDownList($id),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]);
    }

    echo $form->switcher($model, 'partner_in_city');

    echo $form->switcher($model, 'partner_in_city_paid');

    echo $form->switcher($model, 'possibility_to_answer');

    echo $form->switcher($model, 'possibility_to_answer_sale_italy');

    echo $form->switcher($model, 'possibility_to_answer_com_de');

    echo $form->switcher($model, 'pdf_access');

    echo $form->switcher($model, 'show_contacts');

    echo $form->switcher($model, 'show_contacts_on_sale');

    echo $form->switcher($model, 'three_answers_per_month');

    echo $form->switcher($model, 'one_answer_per_month');

    echo $form->switcher($model, 'working_conditions');
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
