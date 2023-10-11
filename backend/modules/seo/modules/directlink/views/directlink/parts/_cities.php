<?php

use kartik\widgets\Select2;
//
use backend\modules\location\models\City;

?>


<?= $form
    ->field($model, 'city_ids')
    ->widget(Select2::class, [
        'data' => City::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) ?>

<p>Если у записи указан город - то эта запись на пользовательской части выводиться только в этом городе</p>

