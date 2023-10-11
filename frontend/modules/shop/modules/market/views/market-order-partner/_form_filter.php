<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};

/**
 * @var $model array
 * @var $params array
 * @var $models array
 */
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => false,
    'id' => 'form-stats',
    'options' => [
        'class' => ''
    ]
]); ?>

<div class="form-filter-date-cont flex form-inline">
    <div class="form-group">
        <label class="control-label" for="full_name"><?= Yii::t('app', 'First name') ?></label>
        <?= Html::input(
            'text',
            'full_name',
            $params['full_name'] ?? null,
            ['class' => 'form-control']
        ) ?>
    </div>

    <div class="form-group">
        <label class="control-label" for="email"><?= Yii::t('app', 'Email') ?></label>
        <?= Html::input(
            'text',
            'email',
            $params['email'] ?? null,
            ['class' => 'form-control']
        ) ?>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-default">Ok</button>
    </div>
</div>

<?php ActiveForm::end(); ?>
