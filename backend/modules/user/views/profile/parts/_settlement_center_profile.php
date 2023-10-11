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

if (in_array($model['user']['group_id'], [8])) {
    echo $form
        ->field($model, 'country_ids')
        ->label(Yii::t('app', 'Ответ на заявку из страны'))
        ->widget(Select2::class, [
            'data' => Country::dropDownList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);?>
    <div class="row control-group">
        <div class="col-md-4">
            <?= $form->switcher($model, 'can_see_all_answers');?>
        </div>
        <div class="col-md-4">
            <?= $form->switcher($model, 'can_see_contacts');?>
        </div>
    </div>
    <?php  
}
