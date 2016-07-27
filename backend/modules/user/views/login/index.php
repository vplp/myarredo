<?php

use yii\helpers\Html;
use backend\themes\inspinia\widgets\forms\ActiveForm;

/**
 * @var \backend\modules\user\models\User $model
 */
?>
<?= \backend\themes\inspinia\widgets\Alert::widget() ?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'class' => 'm-t'
]); ?>
<?= $form->field($model, 'username')->label(); ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
</div>
<?= Html::a('<small>' . Yii::t('app', 'Forgot password?') . '</small>', [\yii\helpers\Url::to('/user/user/request-password-reset')]) ?>
<?php ActiveForm::end(); ?>