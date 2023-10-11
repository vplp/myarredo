<?php
use yii\helpers\Html;
use backend\app\bootstrap\ActiveForm;
use yii\bootstrap\Alert;

?>
<?= Alert::widget() ?>

<?php $form = ActiveForm::begin([
    'id' => 'request-password-reset-form',
    'class' => 'm-t'
]); ?>
<p class="text-center"><?= Yii::t('user', 'Please fill out your email') ?></p>
<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary block full-width m-b']) ?>
</div>

<?php ActiveForm::end(); ?>
