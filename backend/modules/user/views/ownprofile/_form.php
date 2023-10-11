<?php
use yii\helpers\Html;
//
use backend\app\bootstrap\ActiveForm;

/**
 * @var \backend\modules\user\models\Profile $model
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= $form->text_line($model, 'first_name') ?>
<?= $form->text_line($model, 'last_name') ?>
<?= $form->field($model, 'preferred_language')->dropDownList(\Yii::$app->params['themes']['languages']); ?>
<?= $form->field($model, 'avatar')->imageOne($model->getAvatarImage()) ?>
<?= Html::a(Yii::t('user', 'Change password'), ['/user/ownpassword/change', 'id' => $model['id']], ['class' => 'btn btn-info']); ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
