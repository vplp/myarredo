<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use backend\modules\user\models\Profile;
use backend\modules\sys\models\Language;

/**
 * @var $model Profile
 */

?>

<?= $form->text_line($model, 'first_name') ?>

<?= $form->text_line($model, 'last_name') ?>

<?= $form->text_line($model, 'phone') ?>

<?= $form->field($model, 'preferred_language')->dropDownList(\Yii::$app->params['themes']['languages']); ?>

<?= $form->field($model, 'selected_languages')->widget(Select2::classname(), [
    'data' => Language::dropDownList(),
    'options' => ['placeholder' => '...', 'multiple' => true],
    'pluginOptions' => [
        'allowClear' => true
    ]
]) ?>

<?php //$form->field($model, 'avatar')->imageOne($model->getAvatarImage()) ?>

<?php
echo Html::a(
    Yii::t('user', 'Change password'),
    ['/user/password/change', 'id' => $model['id']],
    ['class' => 'btn btn-info']
);
