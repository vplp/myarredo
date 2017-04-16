<?php

use yii\helpers\Html;
use thread\app\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form backend\themes\defaults\widgets\forms\ActiveForm */
/* @var $model \frontend\modules\user\models\form\ResetPasswordForm */

?>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
<p class="text-center"><?= Yii::t('user', 'Please choose your new password:') ?></p>
<?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
