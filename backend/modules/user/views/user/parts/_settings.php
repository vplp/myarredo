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

<?php
echo Html::a(
    Yii::t('user', 'Profile'),
    ['/user/profile/update', 'id' => $model['id']],
    ['class' => 'btn btn-info']
);
