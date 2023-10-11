<?php

use backend\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\forms\models\FormsFeedback $model
 */

$form = ActiveForm::begin();
echo $form->submit($model, $this)
    . $form->field($model, 'name');?>
<div class="form-group field-files-url required">
<label class="control-label" for="files-url">Ссылка</label>
<div class="form-control">/uploads/files/<?=$model->url?></div>
</div>
<? echo $form->field($model, 'url')->fileInputWidget(Yii::$app->getRequest()->hostInfo ."/". $model->url)
    . $form->submit($model, $this);
ActiveForm::end();
