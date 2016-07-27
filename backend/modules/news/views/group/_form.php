<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var \backend\modules\news\models\GroupLang $modelLang
 * @var \backend\modules\news\models\Group $model
 */
$form = ActiveForm::begin();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this, 'left');
echo $form->field($modelLang, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'alias')->textInput(['maxlength' => true]);
echo $form->field($model, 'published')->checkbox();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this, 'left');
ActiveForm::end();
