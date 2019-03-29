<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category, Factory, Types
};

/**
 * @var \backend\modules\catalog\models\ItalianProduct $model
 * @var \backend\modules\catalog\models\ItalianProductLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?= $form->text_line($model, 'factory_name') ?>

<?= $form
    ->field($model, 'catalog_type_id')
    ->widget(Select2::class, [
        'data' => Types::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/product/ajax-get-category');
$script = <<<JS
$('#italianproduct-catalog_type_id').on('change', function () {
    $.post('$url',
        {
            _csrf: $('#token').val(),
            type_id: $(this).find('option:selected').val()
        }
    ).done(function (data) {
        var category = '';
        $.each(data.category, function( key, value ) {
           category += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#italianproduct-category_ids').html(category);
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>

<p>
    Категории напрямую зависит от выбранного типа предмета.<br>
    Если по выбраному типу предмета отсутсвует необходимая категория, зайдите в редактирование
    категории и добавте зависимость с предметом.
</p>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::class, [
        'data' => Category::dropDownList(['type_id' => $model->isNewRecord ? 0 : $model['catalog_type_id']]),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->text_line($model, 'price') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'price_without_technology') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'price_new') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'currency')->dropDownList($model::currencyRange()); ?>
    </div>
</div>

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