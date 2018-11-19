<?php

use backend\modules\catalog\models\Factory;

/**
 * @var $model \backend\modules\user\models\Profile
 */


if (in_array($model['user']['group_id'], [3])) {
    echo $form->field($model, 'factory_id')
        ->selectOne([0 => '--'] + Factory::dropDownList($model->factory_id));

    echo $form->text_line($model, 'email_company');

    echo $form->text_line($model, 'website');

    echo $form->text_line($model, 'address');
}
