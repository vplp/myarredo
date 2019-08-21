<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Factory, FactoryLang
};

/**
 * @var $model Factory
 * @var $modelLang FactoryLang
 * @var $form ActiveForm
 */

echo $form->text_editor_lang($modelLang, 'description');
echo $form->text_editor_lang($modelLang, 'content');
echo $form->text_editor_lang($modelLang, 'contacts');
