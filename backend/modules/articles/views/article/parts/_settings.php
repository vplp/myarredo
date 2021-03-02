<?php

use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use backend\modules\catalog\models\{
    Category, Factory, Types, Specification
};
use backend\modules\location\models\City;

/**
 * @var \backend\modules\articles\models\Article $model
 * @var \backend\modules\articles\models\ArticleLang $modelLang
 * @var \backend\widgets\forms\ActiveForm $form
 */

echo $form->field($model, 'city_id')
    ->widget(Select2::class, [
    'data' => [0 => 'Все города'] + City::dropDownList(),
    'options' => [
        'placeholder' => Yii::t('app', 'Select option'),
        'multiple' => false
    ],
]);

echo $form->field($model, 'category_id')->dropDownList(ArrayHelper::merge(
    [0 => '--' . Yii::t('app', 'Select option') . '--'],
    Category::dropDownList()
));

echo $form->field($model, 'factory_id')->dropDownList(ArrayHelper::merge(
    [0 => '--' . Yii::t('app', 'Select option') . '--'],
    Factory::dropDownList()
));

echo $form
    ->field($model, 'styles_ids')
    ->widget(Select2::class, [
        'data' => Specification::dropDownListParents(9),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]);

echo $form
    ->field($model, 'types_ids')
    ->widget(Select2::class, [
        'data' => Types::dropDownList(['parent_id' => 0]),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
        ],
    ]);

echo $form->text_line_lang($modelLang, 'title');

echo $form->text_line($model, 'alias');

?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'published_time')->datePicker($model->getPublishedTime()) ?>
    </div>
</div>


