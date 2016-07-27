<?php

use backend\themes\inspinia\widgets\forms\ActiveForm;
use thread\widgets\HtmlForm;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 *
 * @var \backend\modules\user\models\Group $model
 * @var \common\modules\user\models\GroupLang $modelLang
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>
<?= $form->field($modelLang, 'title')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'alias')->textInput(['maxlength' => true]); ?>
<?= $model->isNewRecord ? $form->field($model, 'role')->textInput() : ''; ?>
<?= $form->field($model, 'published')->checkbox() ?>
<?= \backend\themes\inspinia\widgets\forms\Form::submit($model, $this); ?>
<?php ActiveForm::end();
