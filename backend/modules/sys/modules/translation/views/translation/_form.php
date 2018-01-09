<?php

use backend\app\bootstrap\ActiveForm;

/** @var  \common\modules\sys\modules\translation\models\Source $model */
/** @var  \common\modules\sys\modules\translation\models\Message $modelLang */
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>

<?= $form->field($model, 'key')->textInput(['disabled' => true]) ?>
<?= $form->text_line_lang($modelLang, 'translation') ?>
<?= $form->switcher($model, 'published') ?>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
