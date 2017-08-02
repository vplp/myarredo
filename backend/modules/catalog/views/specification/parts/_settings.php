<?php

use backend\modules\catalog\models\Specification;

/**
 * @var \backend\modules\news\models\Specification $model
 * @var \backend\modules\news\models\SpecificationLang $modelLang
 */

?>

<?= $form
    ->field($model, 'parent_id')
    ->dropDownList(
        [0 => '--' . Yii::t('app', 'Parent') . '--'] + Specification::dropDownListParents(0)
    ) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->field($model, 'alias')->input('text', ['disabled' => ($model->readonly == '1') ? true : false]) ?>
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