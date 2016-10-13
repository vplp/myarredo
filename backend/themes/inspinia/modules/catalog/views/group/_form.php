<?php

use thread\app\bootstrap\ActiveForm;
//
use backend\modules\catalog\models\Group;

/**
 * @var \backend\modules\catalog\models\GroupLang $modelLang
 * @var \backend\modules\catalog\models\Group $model
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->field($model, 'image_link')->imageOne($model->getImageLink()) ?>
<?= $form->field($model, 'parent_id')->dropDownList([0 => Yii::t('app', 'Not selected')] + Group::getDropdownList()) ?>
<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'published') ?>
    </div>
    <div class="col-md-3">
        <?= $form->text_line($model, 'position') ?>
    </div>
</div>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>