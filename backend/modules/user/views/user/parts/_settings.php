<?php

use yii\helpers\{
    Html, Url
};
use backend\modules\user\models\{
    Group, User
};

/**
 * @var $model User
 */

?>

<?= $form->text_line($model, 'username') ?>

<?= $form->text_line($model, 'email') ?>
<?= $form->text_line($model, 'password')->textInput(['disabled' => true]) ?>

<?php if ($model['id'] != 1) {
    echo $form->field($model, 'group_id')->selectOne(Group::dropDownList());
} ?>

<?php if (!in_array($model['id'], [1])) {
    echo $form->switcher($model, 'published');
} ?>

<p>
    <?= Html::a(Yii::t('user', 'Edit profile'), ['/user/profile/update', 'id' => $model->profile->id]); ?>
</p>
<p>
    <?= Html::a(Yii::t('user', 'Change password'), ['/user/password/change', 'id' => $model->id]); ?>
</p>
