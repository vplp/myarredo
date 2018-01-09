<?php
use backend\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\news\models\GroupLang $modelLang
 * @var \backend\modules\news\models\Group $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'user_id')->dropDownList(\backend\modules\user\models\User::dropDownList()) ?>
<?= $form->text_line($model, 'type')->dropDownList($model::getTypeRange()) ?>
<?= $form->text_line($model, 'message')->textarea(['style' => 'height:100px;']) ?>
<?= $form->text_line($model, 'category')->textarea(['style' => 'height:100px;']) ?>

<div class="row control-group">
    <div class="col-md-3">
        <?= $form->switcher($model, 'is_read') ?>
    </div>
    <div class="col-md-5">
        <?php //= $form->switcher($model, 'published') ?>
    </div>
</div>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
