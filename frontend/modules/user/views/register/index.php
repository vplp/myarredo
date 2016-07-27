<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\modules\user\models\form\CreateForm $model
 */
$this->title = Yii::t('app', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row form-group">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'action' => Url::toRoute('/user/register'),
            ]); ?>
            <?= $form->field($model, 'username')->label(); ?>
            <?= $form->field($model, 'email')->label(); ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'password_confirmation')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <?= Html::a(Yii::t('app', 'Login'), Url::toRoute('/user/login')); ?>
        </div>
    </div>
</div>
