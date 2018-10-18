<?php
use backend\widgets\forms\ActiveForm;

/**
 *
 */
$form = ActiveForm::begin();
echo $form->field($model, 'arraykey')->hiddenInput()->label(false);
?>
    <div class="form-group field-messageslang-title required">
        <label
            class="control-label"><?= $model->getAttributeLabel('on_default_lang') . ': ' . $model['on_default_lang'] ?></label>
    </div>
<?php
echo $form->field($modelLang, 'title')->textInput();
echo \backend\widgets\forms\Form::submit($model, $this, 'left');
ActiveForm::end();
