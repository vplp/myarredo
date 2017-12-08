<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\modules\user\models\form\PasswordResetRequestForm */

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

$this->title = 'Запросить сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <p>Пожалуйста, заполните свой адрес электронной почты. Здесь будет отправлена ссылка на сброс пароля.</p>

                <?php $form = ActiveForm::begin([
                    'id' => 'request-password-reset-form',
                    'action' => Url::toRoute(['/user/password/request-reset']),
                ]); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>
