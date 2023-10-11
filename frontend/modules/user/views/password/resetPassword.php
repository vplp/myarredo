<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\modules\user\models\form\ResetPasswordForm */

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>

<main>
    <div class="page factory-profile">
        <div class="container large-container">

            <?= Html::tag('h1', $this->title); ?>

            <div class="part-contact">

                <p>Выберите новый пароль</p>

                <?php $form = ActiveForm::begin([
                    'id' => 'reset-password-form',
                    //'action' => Url::toRoute('/user/password/reset'),
                ]); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>

