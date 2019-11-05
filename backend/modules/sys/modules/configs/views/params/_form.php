<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\modules\configs\models\{
    Group, Params, ParamsLang
};

/**
 * @var $model Params
 * @var $modelLang ParamsLang
 */

$form = ActiveForm::begin();

echo $form->submit($model, $this);

echo $form
    ->field($model, 'group_id')
    ->dropDownList(
        Group::dropDownList(),
        ['promt' => '---' . Yii::t('app', 'Choose group') . '---']
    );

echo $form->text_line_lang($modelLang, 'title');
echo $form->text_line($model, 'alias');
echo $form->text_editor($modelLang, 'content');

echo $form->submit($model, $this);

ActiveForm::end();
