<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\form\ChangePassword $model
 */
?>

<?php $form = ActiveForm::begin([
    'action' => Url::toRoute(['/user/profile/password-change']),
]); ?>

    <div class="row form-group">
        <div class="col-sm-12">
            <?= Html::tag('h1', 'Password Change') ?>
        </div>
    </div>

<?php if (!empty($model->getFlash())) : ?>

    <div class="row">
        <div class="col-lg-5"><?= implode(',', ($model->getFlash())) ?></div>
    </div>

    <?php
    $model->password_old = '';
    $model->password = '';
    $model->password_confirmation = '';
    ?>

<?php endif; ?>

<?= $form->field($model, 'password_old')->passwordInput() ?>
    <hr/>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_confirmation')->passwordInput() ?>

    <div class="row form-group">
        <div class="col-sm-4">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-sm-8">
            <?= Html::a(Yii::t('app', 'Cancel'), ['/user/profile/index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php
ActiveForm::end();
