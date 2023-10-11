<?php

use kartik\widgets\Select2;
use backend\modules\location\models\{
    Country, City
};

/**
 * @var $model Product
 * @var $modelLang ProductLang
 * @var $form ActiveForm
 */

foreach ($model->noveltyRelCities as $city) {
    $field = 'novelty_rel_cities';
    $model->$field[$city['country_id']][$city['id']] = $city['id'];
}

foreach (Country::dropDownList([1, 2, 3, 4, 5, 85, 114, 109]) as $id => $name) {
    echo $form
        ->field($model, 'novelty_rel_cities[' . $id . ']')
        ->label(Yii::t('app', 'Новинка в городах') . ' (' . $name . ')')
        ->widget(Select2::class, [
            'data' => City::dropDownList($id),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);
}
