<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var \frontend\modules\user\models\Profile $model
 */
$form = ActiveForm::begin([
    'action' => Url::toRoute(['/user/profile/update']),
]); ?>
    <div class="row form-group">
        <div class="col-sm-12">
            <?= Html::tag('h1', 'Profile edit') ?>
        </div>
    </div>
<?= $form->field($model, 'first_name') ?>
<?= $form->field($model, 'last_name') ?>
<?php \thread\widgets\HtmlForm::imageOne($model, 'avatar', ['image_url' => $model->getAvatarImage()]) ?>

    <div class="row form-group">
        <div class="col-sm-4">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-sm-8">
            <?= Html::a(Yii::t('app', 'Cancel'), ['/user/profile/index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php
ActiveForm::end();
