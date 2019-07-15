<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Sale, SaleLang
};

/**
 * @var $form ActiveForm
 * @var $model Sale $model
 * @var $modelLang SaleLang
 */

echo $form->text_editor_lang($modelLang, 'description');
echo $form->text_editor_lang($modelLang, 'content');
