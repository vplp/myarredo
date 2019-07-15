<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var $form ActiveForm
 * @var $model ItalianProduct $model
 * @var $modelLang ItalianProductLang
 */

echo $form->text_editor_lang($modelLang, 'description');
echo $form->text_editor_lang($modelLang, 'defects');
echo $form->text_editor_lang($modelLang, 'material');
