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
    <div class="page sign-in-page">
        <div class="container large-container">

            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['/user/login/index']),
            ]) ?>

            <div class="row flex">
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <h3>
                        <?= Yii::t('app','Вход для зарегистрированных пользователей') ?>
                    </h3>
                    <div class="input-group">

                        <?= $form->field($model, $model->getUsernameAttribute())->label() ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="flex s-between c-align">
                            <?= Html::submitButton(Yii::t('app','Войти'), ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
                            <?= Html::a(Yii::t('app','Забыли пароль?'), ['/user/password/request-reset'], ['class' => 'forgot-pass']) ?>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <h3>
                        <?= Yii::t('app','Регистрация для салонов продаж') ?>
                    </h3>
                    <?= Html::a(Yii::t('app','Зарегистрироваться'), ['/user/register/partner'], ['class' => 'btn btn-default']) ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4">
                    <h3>
                        <?= Yii::t('app','Регистрация для фабрики') ?>
                    </h3>
                    <?= Html::a(Yii::t('app','Войти'), ['/user/login/index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</main>
