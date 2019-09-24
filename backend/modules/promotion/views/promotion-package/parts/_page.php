<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\promotion\models\{
    PromotionPackage, PromotionPackageLang
};

/**
 * @var ActiveForm $form
 * @var PromotionPackage $model
 * @var PromotionPackageLang $modelLang
 */

echo $form->text_line_lang($modelLang, 'description')->textarea(['style' => 'height:200px;']);
echo $form->text_editor_lang($modelLang, 'content');
