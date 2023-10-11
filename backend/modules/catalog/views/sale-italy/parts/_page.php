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

echo $form->text_line_lang($modelLang, 'description')->textarea(['style' => 'height:200px;']);
echo $form->text_line_lang($modelLang, 'defects')->textarea(['style' => 'height:200px;']);
echo $form->text_line_lang($modelLang, 'material')->textarea(['style' => 'height:200px;']);
