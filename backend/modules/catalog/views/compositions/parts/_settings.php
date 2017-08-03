<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category, Collection, Factory
};

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\themes\defaults\widgets\forms\ActiveForm $form
 */
?>

<?= $form->text_line($model, 'alias') ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::classname(), [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Choose factory')],
    ]) ?>

<p>
    Коллекция напрямую зависит от выбранной фабрики.<br>
    Если по выбраной фабрики отсутсвует необходимая Коллекция, зайдите в редактирование
    фабрики и добавте зависимость с фабрикой.
</p>

<?= $form
    ->field($model, 'collections_id')
    ->widget(Select2::classname(), [
        'data' => Collection::dropDownList(['factory_id' => $model->isNewRecord ? 0 : $model['factory_id']]),
        'options' => ['placeholder' => Yii::t('app', 'Choose collection')],
    ]) ?>

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