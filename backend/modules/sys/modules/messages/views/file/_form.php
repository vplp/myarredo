<?php
use backend\widgets\forms\ActiveForm;

/**
 *
 */
$form = ActiveForm::begin();
echo \backend\widgets\forms\Form::submit($model, $this, 'left');
echo $form->field($modelLang, 'title')->textInput(['maxlength' => true]);
echo $form->field($model, 'messagefilepath')->textInput();
ActiveForm::end();

?>
    <div class="form-group field-messageslang-title required">
        <label class="control-label"><?= Yii::t('messages', 'Messages') ?></label>
    </div>
<?php
if ($model->isNewRecord !== true) {
    echo $this->render('../iframe', [
        'link' => ['/sys/messages/messages/list', 'group_id' => $model['id']],
    ]);
}