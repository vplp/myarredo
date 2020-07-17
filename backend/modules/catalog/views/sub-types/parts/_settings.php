<?php

use kartik\widgets\Select2;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Category, Types, TypesLang
};

/**
 * @var $form ActiveForm
 * @var $model Types
 * @var $modelLang TypesLang
 */

?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'plural_name') ?>
<?= $form->text_line($model, 'alias') ?>

<?php if ($this->context->parent) {
    $model->parent_id = $this->context->parent->id;

    echo $form
        ->field($model, 'parent_id')
        ->dropDownList([0 => '--'] + Types::dropDownList(['parent_id' => 0]))
        ->label(Yii::t('app', 'Предмет'));
} else {
    echo $form
        ->field($model, 'category_ids')
        ->widget(Select2::class, [
            'data' => Category::dropDownList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select option'),
                'multiple' => true
            ],
        ]);
} ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
