<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;
use frontend\themes\myarredo\assets\AppAsset;
use frontend\modules\user\models\form\SignInForm;

/**
 * @var $model SignInForm
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
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app', 'Вход для зарегистрированных пользователей') ?>
                            </h3>
                            <div class="in-group">
                                <?= $form
                                    ->field($model, $model->getUsernameAttribute())
                                    ->input(
                                        'text',
                                        ['placeholder' => $model->getAttributeLabel($model->getUsernameAttribute())]
                                    )
                                    ->label(false) ?>

                                <?= $form
                                    ->field($model, 'password')
                                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
                                    ->label(false) ?>

                                <?= $form
                                    ->field($model, 'rememberMe')
                                    ->checkbox() ?>
                            </div>
                            <div class="flex s-between c-align">
                                <?= Html::submitButton(
                                    Yii::t('app', 'Войти'),
                                    ['class' => 'btn btn-default', 'name' => 'login-button']
                                ) ?>
                                <?= Html::a(
                                    Yii::t('app', 'Забыли пароль?'),
                                    ['/user/password/request-reset'],
                                    ['class' => 'forgot-pass']
                                ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app', 'Регистрация для салонов продаж') ?>
                            </h3>

                            <?= Html::a(
                                Html::tag(
                                    'div',
                                    Html::img($bundle->baseUrl . '/img/sign-in1.svg'),
                                    ['class' => 'img-cont']
                                ) .
                                Html::tag(
                                    'div',
                                    Yii::t('app', 'Зарегистрироваться'),
                                    ['class' => 'btn btn-default']
                                ),
                                ['/user/register/partner']
                            ) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app', 'Регистрация для фабрики') ?>
                            </h3>

                            <?= Html::a(
                                Html::tag(
                                    'div',
                                    Html::img($bundle->baseUrl . '/img/sign-in2.svg'),
                                    ['class' => 'img-cont']
                                ) .
                                Html::tag(
                                    'div',
                                    Yii::t('app', 'Зарегистрироваться'),
                                    ['class' => 'btn btn-default']
                                ),
                                ['/user/register/factory']
                            ) ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="square-in">
                            <h3>
                                <?= Yii::t('app', 'Регистрация для логиста') ?>
                            </h3>

                            <?= Html::a(
                                Html::tag(
                                    'div',
                                    Html::img($bundle->baseUrl . '/img/sign-up-3.svg'),
                                    ['class' => 'img-cont']
                                ) .
                                Html::tag(
                                    'div',
                                    Yii::t('app', 'Зарегистрироваться'),
                                    ['class' => 'btn btn-default']
                                ),
                                ['/user/register/logistician']
                            ) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</main>
