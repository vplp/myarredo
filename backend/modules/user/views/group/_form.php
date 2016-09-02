<?php

use thread\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\user\models\Group $model
 * @var \common\modules\user\models\GroupLang $modelLang
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->field($model, 'role')->dropDownList(\backend\modules\sys\modules\user\models\AuthRole::dropDownList()); ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
