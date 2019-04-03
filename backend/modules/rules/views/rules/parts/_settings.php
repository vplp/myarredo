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

echo $form->text_line_lang($modelLang, 'title');

?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>


