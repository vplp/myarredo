<?php

use kartik\widgets\Select2;
//
use backend\modules\location\models\{
    Country, City
};

/**
 * @var $model \backend\modules\user\models\Profile
 */

if (in_array($model['user']['group_id'], [4, 7])) {
    echo $form->text_line($model, 'additional_phone');

    echo $form->text_line($model, 'name_company');

    echo $form->text_line($model, 'website');

    echo $form->text_line($model, 'cape_index');

    echo $form->field($model, 'country_id')
        ->selectOne([0 => '--'] + Country::dropDownList());

    echo $form->field($model, 'city_id')
        ->selectOne([0 => '--'] + City::dropDownList($model->country_id));

    echo $form->text_line($model, 'latitude');

    echo $form->text_line($model, 'longitude');

    echo $form->text_line($model, 'address');

    echo $form
        ->field($model, 'city_ids')
        ->widget(Select2::className(), [
            'data' => City::dropDownList($model->country_id),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);

    echo $form->switcher($model, 'partner_in_city');

    echo $form->switcher($model, 'possibility_to_answer');

    echo $form->switcher($model, 'pdf_access');

    echo $form->switcher($model, 'show_contacts');

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

$this->registerJs($script, yii\web\View::POS_READY);