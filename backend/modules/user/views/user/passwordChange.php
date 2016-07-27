<?php

use backend\modules\user\models\User;
use thread\modules\user\models\form\ChangePassword;
use yii\bootstrap\ActiveForm;
use thread\widgets\HtmlForm;

/**
 * @var ChangePassword|User $model
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?php
if (!empty($model->getFlash())) {
    $model->password = '';
    $model->password_confirmation = '';
} ?>

<?php HtmlForm::passwordInput($model, 'password'); ?>
<?php HtmlForm::passwordInput($model, 'password_confirmation'); ?>

<div class="row form-group">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-4 col-sm-offset-6" style="text-align: right;">
        <?php HtmlForm::buttonPanel($model, $this); ?>
    </div>
</div>
<?php
ActiveForm::end();
