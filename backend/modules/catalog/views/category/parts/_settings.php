<?php

use kartik\widgets\Select2;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Types, Category, CategoryLang
};

/**
 * @var Category $model
 * @var CategoryLang $modelLang
 * @var ActiveForm $form
 */

?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'composition_title') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_en') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_it') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_de') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_fr') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'alias_he') ?>
    </div>
</div>

<?= $form
    ->field($model, 'types_ids')
    ->widget(Select2::class, [
        'data' => Types::dropDownList(['parent_id' => 0]),
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
