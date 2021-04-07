<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\shop\models\Order;
use frontend\modules\catalog\models\Factory;
use frontend\modules\sys\models\Language;
use frontend\themes\myarredo\assets\DataRangePickerAsset;

$bundle = DataRangePickerAsset::register($this);

$lang = substr(Yii::$app->language, 0, 2);

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
        'class' => 'form-filter-date-cont flex form-inline'
    ]
]); ?>

<div class="form-group">
    <label class="control-label" for="full_name"><?= Yii::t('app', 'First name') ?></label>
    <?= Html::input(
        'text',
        'full_name',
        $params['full_name'],
        ['class' => 'form-control']
    ) ?>
</div>

<div class="form-group">
    <label class="control-label" for="phone"><?= Yii::t('app', 'Phone') ?></label>
    <?= Html::input(
        'text',
        'phone',
        $params['phone'],
        ['class' => 'form-control']
    ) ?>
</div>

<div class="form-group">
    <label class="control-label" for="email"><?= Yii::t('app', 'Email') ?></label>
    <?= Html::input(
        'text',
        'email',
        $params['email'],
        ['class' => 'form-control']
    ) ?>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-default">Ok</button>
</div>

<?php ActiveForm::end(); ?>
