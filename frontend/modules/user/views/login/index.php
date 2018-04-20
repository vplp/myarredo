<?php

use frontend\themes\myarredo\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\form\SignInForm $model
 */

$this->title = Yii::t('app', 'Login');
$bundle = AppAsset::register($this);

?>
<main>
    <div class="page sign-in-page">
        <div class="container-wrap">
            <div class="container large-container">

                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['/user/login/index']),
                ]) ?>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app','Вход для зарегистрированных пользователей') ?>
                            </h3>
                            <div class="in-group">

                                <?= $form->field($model, $model->getUsernameAttribute())->label() ?>
                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>
                                <?= $form->field($model, 'rememberMe')->checkbox(['placeholder' => 'Пароль']) ?>

                            </div>

                            <div class="flex s-between c-align">
                                <?= Html::submitButton(Yii::t('app','Войти'), ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
                                <?= Html::a(Yii::t('app','Забыли пароль?'), ['/user/password/request-reset'], ['class' => 'forgot-pass']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app','Регистрация для салонов продаж') ?>
                            </h3>
                            <div class="img-cont">
                                <img src="<?= $bundle->baseUrl ?>/img/sign-in1.svg" alt="">
                            </div>
                            <?= Html::a(Yii::t('app','Зарегистрироваться'), ['/user/register/partner'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app','Регистрация для фабрики') ?>
                            </h3>
                            <div class="img-cont">
                                <img src="<?= $bundle->baseUrl ?>/img/sign-in2.svg" alt="">
                            </div>
                            <?= Html::a(Yii::t('app','Зарегистрироваться'), ['/user/register/factory'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</main>
