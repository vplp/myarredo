<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\modules\translation\models\{
    Source, Message
};

/** @var $model Source */
/** @var $modelLang Message */

$form = ActiveForm::begin();

echo $form->submit($model, $this);

echo $form->text_line($model, 'category');

echo $form->text_line($model, 'key');

echo $form->text_line_lang($modelLang, 'translation');

echo $form->switcher($model, 'published');

echo $form->submit($model, $this);

ActiveForm::end();
