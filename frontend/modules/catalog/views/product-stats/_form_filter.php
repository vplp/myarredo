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

$layout3 = <<< HTML
    <span class="input-group-addon">Дата начала</span>
    {input1}
    {separator}
    <span class="input-group-addon">Дата окончания</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => Url::toRoute(['/catalog/product-stats/list']),
    'id' => 'form-stats',
    'options' => [
        'class' => 'form-filter-date-cont flex'
    ]
]); ?>
    <div class="form-group">
        <?= Select2::widget([
            'name' => 'factory_id',
            'value' => Yii::$app->request->get('factory_id'),
            'data' => [0 => '--'] + Factory::dropDownList(),
            'options' => [
                'id' => 'factory_id',
                'multiple' => false,
                'placeholder' => 'Выберите фабрику'
            ]
        ]); ?>
    </div>

    <div class="form-group">
        <?= Select2::widget([
            'name' => 'country_id',
            'value' => Yii::$app->request->get('country_id'),
            'data' => [0 => '--'] + Country::dropDownList(),
            'options' => [
                'id' => 'country_id',
                'multiple' => false,
                'placeholder' => 'Выберите страну'
            ]
        ]); ?>
    </div>
    <div class="form-group">
        <?= Select2::widget([
            'name' => 'city_id',
            'value' => Yii::$app->request->get('city_id'),
            'data' => [0 => '--'] + City::dropDownList(Yii::$app->request->get('country_id')),
            'options' => [
                'id' => 'city_id',
                'multiple' => false,
                'placeholder' => 'Выберите город'
            ]
        ]); ?>
    </div>
    <div class="form-group">
        <?= DatePicker::widget([
            'name' => 'start_date',
            'name2' => 'end_date',
            'value' => Yii::$app->request->get('start_date'),
            'value2' => Yii::$app->request->get('end_date'),
            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'options' => [
                'id' => 'start_date',
                'placeholder' => 'Дата начала'
            ],
            'options2' => [
                'id' => 'end_date',
                'placeholder' => 'Дата окончания'
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
    var country_id = parseInt($(this).val());
    $.post('/location/location/get-cities/', {_csrf: $('#token').val(),country_id:country_id}, function(data){
        var select = $('select#city_id');
        select.html(data.options);
        select.selectpicker("refresh");
    });
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