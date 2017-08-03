<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category
};

/**
 * @var \backend\modules\catalog\models\Types $model
 * @var \backend\modules\catalog\models\TypesLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */

?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line_lang($modelLang, 'plural_name') ?>
<?= $form->text_line($model, 'alias') ?>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::classname(), [
        'data' => Category::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Choose category'),
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