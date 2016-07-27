<?php

use thread\modules\user\models\form\CreateForm;
use thread\modules\user\models\User;
use yii\widgets\ActiveForm;
use backend\modules\user\models\search\Group;
use thread\widgets\HtmlForm;

/**
 * @var CreateForm|User $model
 */

$form = ActiveForm::begin();

$model->password_old = '';
$model->password = '';
$model->password_confirmation = '';

?>

    <?php HtmlForm::textInput($model, 'username') ?>
    <?php HtmlForm::textInput($model, 'email') ?>
    <?php HtmlForm::dropDownList($model, 'group_id', Group::dropDownList()) ?>
    <?php HtmlForm::passwordInput($model, 'password') ?>
    <?php HtmlForm::passwordInput($model, 'password_confirmation') ?>

    <div class="row form-group">
        <div class="col-sm-2">
            <?php HtmlForm::switcher($model, 'published'); ?>
        </div>
        <div class="col-sm-4 col-sm-offset-6" style="text-align: right;">
            <?php HtmlForm::buttonPanel($model, $this); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
