<?php
use yii\helpers\ArrayHelper;
use backend\modules\news\models\Group;

/**
 * @author Roman Gonchar <roman.gonchar92@gmail.com>
 * @var \backend\modules\news\models\Article $model
 * @var \backend\modules\news\models\ArticleLang $modelLang
 * @var \backend\themes\inspinia\widgets\forms\ActiveForm $form
 */
?>
<?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::merge(
    [0 => '---' . Yii::t('app', 'Choose group') . '---'],
    Group::getDropdownList()
)) ?>
<?= $form->field($modelLang, 'title', [
    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">' . Yii::$app->language . '</span></div>',
])->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'alias')->textInput(['mexlength' => true]) ?>
<?= $form->field($model, 'group_id')->hiddenInput(['value' => 1])->label(false) ?>
<?= $form->field($modelLang, 'description', [
    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">' . Yii::$app->language . '</span></div>',
])->textarea([
    'style' => 'height:100px;'
]) ?>
<?= $form->field($model, 'published_time')->datePicker($model->published_time) ?>
<?= $form->field($model, 'published')->checkbox() ?>
