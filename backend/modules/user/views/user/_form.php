<?php

use yii\helpers\Html;
use backend\app\bootstrap\ActiveForm;
//
use backend\modules\user\models\{
    Group, User
};

/**
 * @var $model User
 */
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?= $form->text_line($model, 'username') ?>
<?= $form->text_line($model, 'email') ?>

<?php if ($model['id'] != 1): echo $form->field($model, 'group_id')->selectOne(Group::dropDownList()); endif; ?>

<?php
if (!in_array($model['id'], [1])):
    echo $form->switcher($model, 'published');
endif; ?>

    <p>
        <?= Html::a(Yii::t('user', 'Edit profile'), ['/user/profile/update', 'id' => $model->profile->id]); ?>
    </p>
    <p>
        <?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change', 'id' => $model->id]); ?>
    </p>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end();
