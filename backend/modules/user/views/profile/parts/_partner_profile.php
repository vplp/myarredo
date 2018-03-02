<?php

use kartik\widgets\Select2;
//
use backend\modules\location\models\{
    City
};

/**
 * @var $model \backend\modules\user\models\Profile
 */

?>

<?php if (in_array($model['user']['group_id'], [4])):

    echo $form
        ->field($model, 'city_ids')
        ->widget(Select2::className(), [
            'data' => City::dropDownList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);

    echo $form->switcher($model, 'partner_in_city');

    echo $form->switcher($model, 'possibility_to_answer');

    echo $form->switcher($model, 'pdf_access');

    echo $form->switcher($model, 'show_contacts');

endif; ?>
