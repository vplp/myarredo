<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category, Factory, Types
};

/**
 * @var \backend\modules\catalog\models\Sale $model
 * @var \backend\modules\catalog\models\SaleLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::classname(), [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Choose factory')],
    ]) ?>

<?= $form
    ->field($model, 'catalog_type_id')
    ->widget(Select2::classname(), [
        'data' => Types::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Choose catalog type')],
    ]) ?>

<p>
    Категории напрямую зависит от выбранного типа предмета.<br>
    Если по выбраному типу предмета отсутсвует необходимая категория, зайдите в редактирование
    категории и добавте зависимость с предметом.
</p>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::classname(), [
        'data' => Category::dropDownList(['type_id' => $model->isNewRecord ? 0 : $model['catalog_type_id']]),
        'options' => [
            'placeholder' => Yii::t('app', 'Choose category'),
            'multiple' => true
        ],
    ]) ?>

<?= $form->text_line($model, 'factory_name') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'price') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'price_new') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'currency')->dropDownList($model::currencyRange()); ?>
    </div>
</div>

<?= $form->text_line($model, 'country_code') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'on_main') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>