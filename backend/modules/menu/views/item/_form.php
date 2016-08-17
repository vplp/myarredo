<?php
use yii\helpers\Html;
//
use thread\app\bootstrap\ActiveForm;
//
use backend\modules\menu\models\search\MenuItem;


?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= Html::activeHiddenInput($model, 'group_id', ['value' => $this->context->group->id]) ?>
<?= Html::activeHiddenInput($model, 'parent_id',
    [
        'value' => (Yii::$app->request->get('parent_id'))
            ? Yii::$app->request->get('parent_id')
            : 0
    ]
) ?>

<?= $form->text_line_lang($modelLang, 'title') ?>
<hr>
<?= $form->field($model, 'link_type')->dropDownList(MenuItem::linkTypeRange()) ?>
<?= $form->field($model, 'link_target')->dropDownList(MenuItem::linkTargetRange()) ?>

<?= $form->text_line($model, 'link') ?>
<?php // TODO:: Зависимые дропдауны для выбора модуля и его элементов
// HtmlForm::dropDownList($model, 'internal_source_id', Page::dropDownList()) ?>
<hr>
<?= $form->field($model, 'type')->dropDownList(MenuItem::typeRange()) ?>

<?= $form->text_line($model, 'position')->value(0) ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
