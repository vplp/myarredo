<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\forms\models\Topic;

/**
 * @var \backend\modules\forms\models\Feedbackform $model

 */
$form = ActiveForm::begin();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this);
echo $form->field($model, 'name')->textInput(['maxlength' => true]);
echo $form->field($model, 'topic_id')->dropDownList(ArrayHelper::merge(
    ['' => '---' . Yii::t('app', 'Choose topic') . '---'],
    Topic::getDropdownList()
));
echo $form->field($model, 'question')->textInput(['maxlength' => true]);
echo $form->field($model, 'email')->textInput(['maxlength' => true]);
echo $form->field($model, 'phone')->textInput(['maxlength' => true]);
echo $form->field($model, 'published')->checkbox();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this);
ActiveForm::end();
