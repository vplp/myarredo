<?php

use backend\modules\catalog\models\{
    Specification, SpecificationLang
};

/**
 * @var Specification $model
 * @var SpecificationLang $modelLang
 */

?>

<?= $form
    ->field($model, 'parent_id')
    ->dropDownList(
        [0 => '--' . Yii::t('app', 'Parent') . '--'] + Specification::dropDownListParents(0)
    ) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>

<div class="row control-group">
    <div class="col-md-6">
        <?= $form->field($model, 'alias')->input('text', ['disabled' => ($model->readonly == '1') ? true : false]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'alias2')->input('text', ['disabled' => ($model->readonly == '1') ? true : false]) ?>
    </div>
</div>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
    <div class="col-md-3">
        <?= $form->switcher($model, 'type') ?>
    </div>
</div>