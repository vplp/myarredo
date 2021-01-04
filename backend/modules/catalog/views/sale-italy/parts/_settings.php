<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Category, Factory, Types, SubTypes
};
use backend\modules\catalog\models\{
    ItalianProduct, ItalianProductLang
};

/**
 * @var $form ActiveForm
 * @var $model ItalianProduct $model
 * @var $modelLang ItalianProductLang
 */
?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form->text_line($model, 'alias') ?>

<?= $form->text_line($model, 'alias_en') ?>

<?= $form->text_line($model, 'alias_it') ?>

<?= $form->text_line($model, 'alias_de') ?>

<?= $form->text_line($model, 'alias_he') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?= $form->text_line($model, 'factory_name') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form
            ->field($model, 'catalog_type_id')
            ->label(Yii::t('app', 'Предмет'))
            ->widget(Select2::class, [
                'data' => Types::dropDownList(),
                'options' => ['placeholder' => Yii::t('app', 'Select option')],
            ]) ?>
    </div>
    <div class="col-md-9">
        <?= $form
            ->field($model, 'subtypes_ids')
            ->widget(Select2::class, [
                'data' => SubTypes::dropDownList(['parent_id' => $model->isNewRecord ? -1 : $model['catalog_type_id']]),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select option'),
                    'multiple' => true
                ],
            ]) ?>
    </div>
</div>

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
        
        var subtypes = '';
        $.each(data.subtypes, function( key, value ) {
           subtypes += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#italianproduct-subtypes_ids').html(subtypes);        
    });
});
JS;

$this->registerJs($script);
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
        <?= $form->field($model, 'create_mode')->dropDownList($model::createModeRange(), ['disabled' => true]); ?>
    </div>
    <div class="col-md-3">
        <?= Html::label(Yii::t('app', 'Payment status')) ?>
        <div class="form-control">
            <?php

            $status = $model->payment ? Yii::t('app', ucfirst($model->payment->payment_status)) : '-';

            if ($model->payment && $model->payment->payment_status == 'success') {
                $status .= ' ' . date('Y-m-d', $model->payment->payment_time);
            }

            echo $status;
            ?>
        </div>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList($model::statusRange()); ?>
    </div>
</div>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'on_main') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'is_sold') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'bestseller') ?>
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
