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
<?= $form->field($model, 'group_id')->hiddenInput(['value' => 1])->label(false) ?>
<?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::merge(
    [0 => '---' . Yii::t('app', 'Choose group') . '---'],
    Group::getDropdownList()
)) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->text_line_lang($modelLang, 'description')->textarea([
    'style' => 'height:100px;'
]) ?>
<?= $form->field($model, 'published_time')->datePicker($model->getPublishedTime()) ?>
<?= $form->switcher($model, 'published') ?>
