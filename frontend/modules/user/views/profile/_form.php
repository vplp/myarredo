<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \frontend\modules\user\models\Profile $model
 */
$form = ActiveForm::begin([
    'action' => Url::toRoute(['/user/profile/update']),
]); ?>

<?= $form->field($model, 'first_name'); ?>
<?= $form->field($model, 'last_name'); ?>
<?= $form->field($model, 'preferred_language'); ?>
<?php \thread\widgets\HtmlForm::imageOne($model, 'avatar', ['image_url' => '']) ?>

<div class="row form-group">
    <div class="col-sm-4 col-sm-offset-6">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']); ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Url::toRoute(['/user/profile/index']), ['class' => 'btn btn-primary']); ?>
    </div>
</div>

<?php
ActiveForm::end();
