<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\rules\models\{
    Rules, RulesLang
};

/**
 * @var ActiveForm $form
 * @var Rules $model
 * @var RulesLang $modelLang
 */

echo $form->text_editor_lang($modelLang, 'content');
