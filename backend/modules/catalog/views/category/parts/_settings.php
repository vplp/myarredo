<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Types
};

/**
 * @var \backend\modules\catalog\models\Category $model
 * @var \backend\modules\catalog\models\CategoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'composition_title') ?>
<?= $form->text_line($model, 'alias') ?>

<?= $form
    ->field($model, 'types_ids')
    ->widget(Select2::class, [
        'data' => Types::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'popular') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'popular_by') ?>
    </div>
</div>
