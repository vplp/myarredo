<?php
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 *
 */
$form = ActiveForm::begin();
//echo $form->field($model, 'group_id')->dropDownList(\backend\modules\messages\models\MessagesFile::dropDownList());
//echo $form->field($model, 'alias')->textInput();
echo $form->field($model, 'arraykey')->hiddenInput()->label(false);
?>
    <div class="form-group field-messageslang-title required">
        <label
            class="control-label"><?= $model->getAttributeLabel('on_default_lang') . ': ' . $model['on_default_lang'] ?></label>
    </div>
<?php
echo $form->field($modelLang, 'title')->textInput();
echo \backend\themes\inspinia\widgets\forms\Form::submit($model, $this, 'left');
ActiveForm::end();
