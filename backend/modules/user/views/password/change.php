<?php
use backend\app\bootstrap\ActiveForm;
use thread\modules\user\models\form\ChangePassword;
//
use backend\modules\user\models\User;

/**
 * @var ChangePassword|User $model
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?php
if (!empty(Yii::$app->session->getFlash('success'))) {
    $model->password = '';
    $model->password_confirmation = '';
} ?>
<?= $form->submit($model, $this) ?>
    <div class="row form-group">
        <div class="col-sm-12">
            <h1><?= $user['profile']->getFullName() ?></h1>
        </div>
    </div>

<?= $form->text_password($model, 'password') ?>
<?= $form->text_password($model, 'password_confirmation') ?>

<?= $form->submit($model, $this) ?>
<?php
ActiveForm::end();
