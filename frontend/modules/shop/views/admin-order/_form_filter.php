<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use frontend\modules\location\models\{
    Country, City
};

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => Url::toRoute(['/shop/admin-order/list']),
    'id' => 'form-stats',
    'options' => [
        'class' => 'form-filter-date-cont flex'
    ]
]); ?>

    <div class="form-group">
        <?= Select2::widget([
            'name' => 'country_id',
            'value' => $params['country_id'],
            'data' => [0 => '--'] + Country::dropDownList(),
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
            'data' => [0 => '--'] + City::dropDownList($params['country_id']),
            'options' => [
                'id' => 'city_id',
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Select a city')
            ]
        ]); ?>
    </div>

    <div class="form-group">
        <div class="form-control">Количество заявок: <?= $models->getTotalCount() ?></div>
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

$this->registerJs($script, yii\web\View::POS_READY);
?>