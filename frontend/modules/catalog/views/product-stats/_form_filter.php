<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use frontend\modules\catalog\models\Factory;
use frontend\modules\location\models\{
    Country, City
};

$start_date = Yii::t('app', 'Start date');
$end_date = Yii::t('app', 'End date');

$layout3 = <<< HTML
    <span class="input-group-addon">$start_date</span>
    {input1}
    {separator}
    <span class="input-group-addon">$end_date</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => false,
    'id' => 'form-stats',
    'options' => [
        'class' => 'form-filter-date-cont flex'
    ]
]); ?>

<?php if (Yii::$app->getUser()->getIdentity()->group->role == 'admin' && isset($params['factory_id'])): ?>
    <div class="form-group">
        <?= Select2::widget([
            'name' => 'factory_id',
            'value' => $params['factory_id'],
            'data' => [0 => '--'] + Factory::dropDownList(),
            'options' => [
                'id' => 'factory_id',
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Choose factory')
            ]
        ]); ?>
    </div>
<?php endif; ?>

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
            'value' => $params['city_id'],
            'data' => [0 => '--'] + City::dropDownList($params['country_id']),
            'options' => [
                'id' => 'city_id',
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Select a city')
            ]
        ]); ?>
    </div>
    <div class="form-group">
        <?= DatePicker::widget([
            'name' => 'start_date',
            'name2' => 'end_date',
            'value' => $params['start_date'],
            'value2' => $params['end_date'],
            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'options' => [
                'id' => 'start_date',
                'placeholder' => Yii::t('app', 'Start date')
            ],
            'options2' => [
                'id' => 'end_date',
                'placeholder' => Yii::t('app', 'End date')
            ],
            'layout' => $layout3,
            'type' => DatePicker::TYPE_RANGE,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-m-yyyy'
            ]
        ]); ?>
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
$('select#factory_id').change(function(){
  $('#form-stats').submit();
});
$('input#start_date').change(function(){
  $('#form-stats').submit();
});
$('input#end_date').change(function(){
  $('#form-stats').submit();
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);
?>