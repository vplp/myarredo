<?php

use kartik\widgets\Select2;
//
use backend\modules\catalog\models\{
    Category, Collection, Factory
};

/**
 * @var \backend\modules\catalog\models\Factory $model
 * @var \backend\modules\catalog\models\FactoryLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */
?>

<?= $form->text_line($model, 'alias') ?>

<?= $form->text_line_lang($modelLang, 'title') ?>

<?= $form
    ->field($model, 'factory_id')
    ->widget(Select2::class, [
        'data' => Factory::dropDownList(),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?php
$url = \yii\helpers\Url::toRoute('/catalog/product/ajax-get-collection');
$script = <<<JS
$('#composition-factory_id').on('change', function () {
    $.post('$url',
        {
            _csrf: $('#token').val(),
            factory_id: $(this).find('option:selected').val()
        }
    ).done(function (data) {
        var collection = '';
        $.each(data.collection, function( key, value ) {
           collection += '<option value="'+ key +'">' + value + '</option>';
        });
        $('#composition-collections_id').html(collection);
    });
});
JS;

$this->registerJs($script);
?>

<p>
    Коллекция напрямую зависит от выбранной фабрики.<br>
    Если по выбраной фабрики отсутсвует необходимая Коллекция, зайдите в редактирование
    фабрики и добавте зависимость с фабрикой.
</p>

<?= $form
    ->field($model, 'collections_id')
    ->widget(Select2::class, [
        'data' => Collection::dropDownList(['factory_id' => $model->isNewRecord ? 0 : $model['factory_id']]),
        'options' => ['placeholder' => Yii::t('app', 'Select option')],
    ]) ?>

<?= $form
    ->field($model, 'category_ids')
    ->widget(Select2::class, [
        'data' => Category::dropDownList(),
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