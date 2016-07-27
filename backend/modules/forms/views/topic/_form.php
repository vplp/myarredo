<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var \backend\modules\forms\models\TopicLang $modelLang
 * @var \backend\modules\forms\models\Topic $model
 */
$form = ActiveForm::begin();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this);
echo $form->field($modelLang, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'sort')->textInput(['maxlength' => true]);
echo $form->field($model, 'published')->checkbox();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this);
ActiveForm::end();
