<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\sys\modules\user\models\AuthRole;

/**
 * @var \backend\modules\user\models\Group $model
 * @var \common\modules\user\models\GroupLang $modelLang
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line_lang($modelLang, 'title') ?>
<?= $form->text_line($model, 'alias') ?>
<?= $form->field($model, 'role')->selectOne(AuthRole::dropDownList()); ?>
<?= $form->switcher($model, 'published') ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
