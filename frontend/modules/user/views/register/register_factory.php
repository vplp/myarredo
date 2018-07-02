<?php

use frontend\themes\myarredo\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
//
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\Profile;
$bundle = AppAsset::register($this);

/**
 * @var \frontend\modules\user\models\form\RegisterForm $model
 */

$this->title = Yii::t('app', 'Регистрация для фабрики');

$model->user_agreement = 1;
?>

<main>
    <div class="page sign-up-page">
        <div class="container-wrap">
            <div class="container large-container">
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'action' => Url::toRoute('/user/register/factory'),
                ]); ?>
                <div class="row">

                    <div class="col-sm-12 col-md-2">
                        <?= Html::tag('h2', $this->title); ?>
                        <div class="img-cont">
                            <img src="<?= $bundle->baseUrl ?>/img/sign-up-2.svg" alt="">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 right-border">
                        <div class="form-block-in">
                            <?= $form->field($model, 'factory_package')
                                ->dropDownList(
                                    Profile::factoryPackageKeyRange(),
                                    ['class' => 'selectpicker']
                                ) ?>

                            <?= $form->field($model, 'name_company') ?>

                            <?= $form->field($model, 'address') ?>

                            <?= $form->field($model, 'country_id')
                                ->input('hidden', ['value' => 0])
                                ->label(false) ?>

                            <?= $form->field($model, 'city_id')
                                ->input('hidden', ['value' => 0])
                                ->label(false) ?>

                            <?= $form->field($model, 'phone')
                                ->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => '+39 (99) 999-99-99',
                                    'clientOptions' => [
                                        'clearIncomplete' => true
                                    ]
                                ]) ?>

                            <?= $form->field($model, 'website') ?>

                            <?= $form->field($model, 'last_name') ?>

                            <?= $form->field($model, 'first_name') ?>

                            <?= $form->field($model, 'email') ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>

                            <?= $form->field($model, 'password_confirmation')->passwordInput() ?>

                            <?= $form->field($model, 'user_agreement', ['template' => '{input}{label}{error}{hint}'])->checkbox([], false)
                                ->label('&nbsp;' . $model->getAttributeLabel('user_agreement')) ?>

                            <?= $form->field($model, 'reCaptcha')
                                ->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())
                                ->label(false) ?>

                            <div class="a-warning">
                                * <?= Yii::t('app', 'Поля обязательны для заполнения') ?>
                            </div>

                            <?= Html::submitButton(Yii::t('app', 'Зарегистрироваться'), ['class' => 'btn btn-success']) ?>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                        <div class="text">
                            <?= Yii::$app->param->getByName('USER_FACTORY_REG_TEXT') ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>