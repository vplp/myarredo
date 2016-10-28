<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\user\models\Profile $model
 */
?>
<div class="row form-group">
    <div class="col-sm-4">
        <?= Html::activeLabel($model, 'first_name') ?>
    </div>
    <div class="col-sm-8">
        <?= $model['first_name'] ?>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-4">
        <?= Html::activeLabel($model, 'last_name') ?>
    </div>
    <div class="col-sm-8">
        <?= $model['last_name'] ?>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-4">
        <?= Html::activeLabel($model, 'preferred_language') ?>
    </div>
    <div class="col-sm-8">
        <?= $model['preferred_language'] ?>
    </div>
</div>
<div class="row form-group">
    <div class="col-sm-4">
        <?= Html::a(Yii::t('app', 'Edit'), ['/user/profile/update']) ?>
    </div>
    <div class="col-sm-8">
        <?= Html::a(Yii::t('app', 'Change password'), ['/user/profile/password-change']) ?>
    </div>
</div>
