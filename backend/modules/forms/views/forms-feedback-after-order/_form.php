<?php

use backend\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\forms\models\FormsFeedback $model
 */

$form = ActiveForm::begin();
echo $form->submit($model, $this);
?>
<div class="form-group">
    <label class="control-label" for="user-password"><?=Yii::t('app', 'Name')?></label>
    <input type="text" id="user" class="form-control" name="" value="<?=$model->order->customer->full_name?>" disabled="" placeholder="<?=Yii::t('app', 'Name')?>">
    <p class="help-block help-block-error"></p>
</div>

<div class="form-group">
    <?= $form->text_line($model, 'order_id', array('disabled'=>'disabled'));?>
</div>

<div class="form-group">
    <?= $form->field($model, 'question_1'); ?>
</div>

<div class="form-group">
    <?php if ($model->partner->profile->lang){
        echo $form->text_line($model->partner->profile->lang, 'name_company', array('disabled'=>'disabled'));
    } else {
        echo $form->text_line($model->partner, 'username', array('disabled'=>'disabled'));
    }?>
</div>

<div class="form-group">
    <?= $form->field($model, 'vote'); ?>
</div>

<div class="form-group">
    <?= $form->field($model, 'question_3'); ?>
</div>

<div class="form-group">
    <?= $form->field($model, 'question_4'); ?>
</div>

<div class="form-group">
    <?= $form->switcher($model, 'published'); ?>
</div>

<?php echo $form->submit($model, $this);
ActiveForm::end();
?>