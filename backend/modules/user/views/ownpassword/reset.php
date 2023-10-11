<?php

use yii\helpers\Html;
use backend\app\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\user\models\form\ResetPasswordForm */

?>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
<p class="text-center"><?= Yii::t('user', 'Please choose your new password:') ?></p>
<?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
