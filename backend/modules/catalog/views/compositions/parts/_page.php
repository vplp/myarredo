<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Composition, CompositionLang
};

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $modelLang CompositionLang
 */

echo $form->text_editor_lang($modelLang, 'description');
