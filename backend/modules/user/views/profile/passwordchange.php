<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use thread\widgets\HtmlForm;

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
$form = ActiveForm::begin();
?>
<?php
if (!empty($model->getFlash())) :
    ?>
    <div class="row">
        <div class="col-lg-5"><?= implode(',', ($model->getFlash())); ?></div>
    </div>
    <?php
    $model->password_old = '';
    $model->password = '';
    $model->password_confirmation = '';

endif;
?>
<?= $form->field($model, 'password_old')->passwordInput(); ?>
<hr />
<?= $form->field($model, 'password')->passwordInput(); ?>
<?= $form->field($model, 'password_confirmation')->passwordInput(); ?>
<div class="row form-group">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-4 col-sm-offset-6" style="text-align: right;">
        <?= Html::hiddenInput('save_and_exit'); ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add and Exit') : Yii::t('app', 'Save and Exit'), ['class' => 'btn btn-success action_save_and_exit']); ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Save'), ['class' => 'btn btn-info']); ?>
        <?= Html::a(Yii::t('app', 'Cancel'), ['update', 'id' => Yii::$app->getRequest()->get('id')], ['class' => 'btn btn-danger']); ?>
        <?php
        $this->registerJs("$('.action_save_and_exit').click(function(){
                    $('input[name=\"save_and_exit\"]').val(1);
                });");
        ?>
    </div>
</div>
<?php
ActiveForm::end();
