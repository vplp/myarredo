<?php

/* @var $this yii\web\View */
/* @var $form backend\themes\inspinia\widgets\forms\ActiveForm */
/* @var $model \frontend\modules\user\models\form\ResetPasswordForm */

use yii\helpers\Html;
use thread\app\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
    <p class="text-center"><?= Yii::t('app', 'Please choose your new password:') ?></p>
    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
