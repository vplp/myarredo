<?php

use yii\helpers\Html;
//
use backend\modules\user\models\Profile;

/**
 * @var $model Profile
 */

?>

<?= $form->text_line($model, 'first_name') ?>

<?= $form->text_line($model, 'last_name') ?>

<?= $form->text_line($model, 'phone') ?>

<?= $form->field($model, 'preferred_language')->dropDownList(\Yii::$app->params['themes']['languages']); ?>

<?php //$form->field($model, 'avatar')->imageOne($model->getAvatarImage()) ?>

<?php

echo Html::a(
    Yii::t('user', 'Change password'),
    ['/user/password/change', 'id' => $model['id']],
    ['class' => 'btn btn-info']
);
