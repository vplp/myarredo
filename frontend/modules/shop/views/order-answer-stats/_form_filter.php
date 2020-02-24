<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\User;

/**
 * @var $models User[]
 */
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => false,
    'id' => 'form-stats',
    'options' => [
        'class' => 'form-filter-date-cont flex'
    ]
]); ?>

    <div class="form-group">
        <?= Select2::widget([
            'name' => 'country_id',
            'value' => $params['country_id'],
            'data' => [0 => Yii::t('app', 'Все страны')] + Country::dropDownList([1, 2, 3, 4]),
            'options' => [
                'id' => 'country_id',
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Choose the country')
            ]
        ]); ?>
    </div>

    <div class="form-group">
        <?= Select2::widget([
            'name' => 'city_id',
            'value' => (!is_array($params['city_id'])) ? $params['city_id'] : 0,
            'data' => [0 => Yii::t('app', 'Все города')] + City::dropDownList($params['country_id']),
            'options' => [
                'id' => 'city_id',
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Select a city')
            ]
        ]); ?>
    </div>

    <div class="form-group">
        <div class="form-control"><?= Yii::t('app', 'Количество') ?>: <?= $models->getTotalCount() ?></div>
    </div>

<?php ActiveForm::end(); ?>

<?php

$script = <<<JS
$('select#country_id').change(function(){
    $('select#city_id').val(0);
    $('#form-stats').submit();
});
$('select#city_id').change(function(){
    $('#form-stats').submit();
});
JS;

$this->registerJs($script);
?>
