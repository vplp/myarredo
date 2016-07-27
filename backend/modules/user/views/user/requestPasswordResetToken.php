<?php

/* @var $this yii\web\View */
/* @var $form backend\themes\inspinia\widgets\forms\ActiveForm */
/* @var $model \common\modules\user\models\form\PasswordResetRequestForm */

use yii\helpers\Html;
use backend\themes\inspinia\widgets\forms\ActiveForm;

?>
<?= \backend\themes\inspinia\widgets\Alert::widget() ?>

<?php $form = ActiveForm::begin([
    'id' => 'request-password-reset-form',
    'class' => 'm-t'
]); ?>
    <p class="text-center"><?= Yii::t('app', 'Please fill out your email') ?></p>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary block full-width m-b']) ?>
    </div>

<?php ActiveForm::end(); ?>
