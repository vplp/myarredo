<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\form\SignInForm $model
 */

$this->title = Yii::t('app', 'Login');

?>
<main>
    <div class="page sign-up-page">
        <div class="container large-container">

            <div class="row">
                <?= Html::tag('h2', $this->title); ?>

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/user/login/index']),
                ]) ?>
                <?= $form->field($model, $model->getUsernameAttribute())->label() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>


                <?= Html::a(Yii::t('app', 'Registration'), ['/user/register/index']) ?>

                </div>
                <div class="col-xs-12 col-sm-6 col-lg-offset-2 col-sm-6 col-md-6 col-lg-5">

                </div>
            </div>

        </div>
    </div>
</main>
