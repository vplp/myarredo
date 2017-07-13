<?php

use yii\helpers\Html;
use thread\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\user\models\User $model
 */
?>
<?= \backend\themes\defaults\widgets\Alert::widget() ?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'class' => 'm-t'
]); ?>
<?= $form->field($model, 'username')->label(); ?>
<?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
    </div>
<?= Html::a('<small>' . Yii::t('user', 'Forgot password?') . '</small>', ['/user/password/request-reset']) ?>
<?php ActiveForm::end(); ?>