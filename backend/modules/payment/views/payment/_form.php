<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\payment\models\Payment;

/**
 * @var $model Payment
 */

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->field($model, 'user_id') ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->field($model, 'type')->dropDownList(Payment::getTypeKeyRange()) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'promotion_package_id') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'change_tariff')->dropDownList(Payment::statusKeyRange()) ?>
        </div>
    </div>

<?= $form->field($model, 'tariffs') ?>

    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->field($model, 'amount') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'currency')->dropDownList(Payment::getCurrencyKeyRange()) ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->field($model, 'payment_status')->dropDownList(Payment::paymentStatusRange()) ?>
        </div>
        <div class="col-md-3">
            <?= $form
                ->field($model, 'payment_time')
                ->dateTimePicker(date('d.m.Y H:i', $model->payment_time), 'dd.mm.yyyy hh:ii') ?>
        </div>
    </div>
    <div class="row control-group">
        <div class="col-md-3">
            <?= $form->switcher($model, 'published') ?>
        </div>
    </div>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
