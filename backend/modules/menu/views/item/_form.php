<?php

use backend\modules\menu\models\search\MenuItem;
use thread\modules\menu\models\Menu;
use thread\modules\page\models\Page;
use backend\themes\inspinia\widgets\forms\ActiveForm;
use thread\widgets\HtmlForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>
<div class="row form-group">
    <div class="col-sm-12">
        <?php HtmlForm::buttonPanel($model, $this) ?>
    </div>
</div>
<?= Html::activeHiddenInput($model, 'group_id', ['value' => $this->context->group->id]) ?>
<?= Html::activeHiddenInput($model, 'parent_id',
    [
        'value' => (Yii::$app->request->get('parent_id'))
            ? Yii::$app->request->get('parent_id')
            : 0
    ]
) ?>

<?php HtmlForm::textInput($modelLang, 'title') ?>

<hr>
<?php HtmlForm::dropDownList($model, 'link_type', MenuItem::linkTypeRange()) ?>
<?php HtmlForm::dropDownList($model, 'link_target', MenuItem::linkTargetRange()) ?>

<?php HtmlForm::textInput($model, 'link') ?>
<?php // TODO:: Зависимые дропдауны для выбора модуля и его элементов
// HtmlForm::dropDownList($model, 'internal_source_id', Page::dropDownList()) ?>
<hr>
<?php HtmlForm::dropDownList($model, 'type', MenuItem::typeRange()) ?>

<?php HtmlForm::textInput($model, 'position', ['value' => 0]) ?>

<div class="row form-group">
    <div class="col-sm-2">
        <?php HtmlForm::switcher($model, 'published') ?>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-12">
        <?php HtmlForm::buttonPanel($model, $this) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
