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

echo $form->text_line_lang($modelLang, 'title');
?>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'price') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'currency')->dropDownList(['EUR' => 'EUR']); ?>
    </div>
</div>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>