<?php

use backend\modules\news\models\Group;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use backend\modules\catalog\models\{
    Category, Factory, Types, Specification
};
use backend\modules\location\models\City;

/**
 * @var \backend\modules\news\models\Article $model
 * @var \backend\modules\news\models\ArticleLang $modelLang
 * @var \backend\widgets\forms\ActiveForm $form
 */

echo $form
    ->field($model, 'city_ids')
    ->widget(Select2::class, [
        'data' => City::dropDownList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select option'),
            'multiple' => true
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
?>

<?= $form->field($model, 'group_id')->hiddenInput(['value' => 1])->label(false) ?>
<?= ''; //$form->field($model, 'group_id')->dropDownList(Group::dropDownList(), ['prompt' => '---' . Yii::t('app', 'Choose group') . '---'])  ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'published_time')->datePicker($model->getPublishedTime()) ?>
    </div>
</div>
