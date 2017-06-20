<?php

use thread\app\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \frontend\modules\user\models\form\SignInForm $model
 */
$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row form-group">
        <div class="col-md-5">

            <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, $model->getUsernameAttribute())->label() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-5">
            <?= Html::a(Yii::t('app', 'Registration'), ['/user/register/index']) ?>
        </div>
    </div>
</div>
