<?php

use kartik\widgets\Select2;
use backend\modules\catalog\models\Factory;

/**
 * @var \backend\modules\catalog\models\Product $model
 * @var \backend\modules\catalog\models\ProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ])  ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
</div>
