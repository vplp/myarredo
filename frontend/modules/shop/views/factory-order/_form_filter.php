<?php

use yii\widgets\ActiveForm;
use yii\helpers\{
    Html, Url
};
use kartik\widgets\Select2;
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\catalog\models\Factory;
use frontend\themes\myarredo\assets\DataRangePickerAsset;

$bundle = DataRangePickerAsset::register($this);

$lang = substr(Yii::$app->language, 0, 2);

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'id' => 'form-stats',
    'action' => false,
    'options' => [
        'class' => 'form-filter-date-cont flex'
    ]
]); ?>


    <div class="form-group">
        <?= Select2::widget([
            'name' => 'country_id',
            'value' => $params['country_id'],
            'data' => [0 => Yii::t('app', 'Все страны')] + Country::dropDownListWithOrders(),
            'options' => [
                'id' => 'country_id',
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Choose the country')
            ]
        ]); ?>
    </div>


<div class="form-group">
    <?= Select2::widget([
        'name' => 'factory_id',
        'value' => (!is_array($params['factory_id'])) ? $params['factory_id'] : 0,
        'data' => [0 => Yii::t('app', 'Все фабрики')] + Factory::dropDownList($params['factory_id']),
        'options' => [
            'id' => 'factory_id',
            'multiple' => false,
            'placeholder' => Yii::t('app', 'Select option')
        ]
    ]); ?>
</div>

<div class="form-group dropdown large-picker">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
        <input type="text" class="drop-date-picker" readonly
               value="<?= $params['start_date'] . '-' . $params['end_date'] ?>">
    </button>
    <div class="dropdown-menu datepicker-drop">
        <div class="range-inputs">
            <label>
                <?= Html::input(
                    'text',
                    'start_date',
                    $params['start_date'],
                    ['class' => 'input-mini range-a']
                ) ?>
                -
                <?= Html::input(
                    'text',
                    'end_date',
                    $params['end_date'],
                    ['class' => 'input-mini range-b']
                ) ?>
            </label>
        </div>
        <div class="flex btns-cont">
            <button type="button" class="btn btn-success dropdown-toggle change-date"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= Yii::t('app', 'Apply') ?>
            </button>
            <button type="button" class="btn btn-default dropdown-toggle"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?= Yii::t('app', 'Cancel') ?>
            </button>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="form-control"><?= Yii::t('app', 'Количество') ?>: <?= $models->getTotalCount() ?></div>
</div>

<?php ActiveForm::end(); ?>

<?php

$dateRangeLabel = Yii::t('app', 'Диапазон дат');
$lastMonthLabel = Yii::t('app', 'Прошлый месяц');
$currentMonthLabel = Yii::t('app', 'Текущий месяц');
$oneMonthLabel = Yii::t('app', 'За 30 дней');
$weekLabel = Yii::t('app', 'Неделя');
$yesterdayLabel = Yii::t('app', 'Вчера');
$todayLabel = Yii::t('app', 'Сегодня');

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
$('.change-date').on('click', function () {
    $('#form-stats').submit();
});
if (typeof $.datepicker !== 'undefined') {
$.datepicker.regional['ru'] = {
    closeText: 'Закрыть',
    prevText: '&#x3c;Пред',
    nextText: 'След&#x3e;',
    currentText: 'Сегодня',
    monthNames: [
        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
    ],
    monthNamesShort: [
        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
    ],
    dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
    dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
    dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
    weekHeader: 'Нед',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};

$(".drop-date-picker").daterangepicker({
    posX: null,
    posY: null,
    dateFormat: 'dd.mm.yy',
    rangeStartTitle: '',
    rangeEndTitle: '',
    presetRanges: [
        {text: '$todayLabel', dateStart: 'today', dateEnd: 'today'},
        {text: '$yesterdayLabel', dateStart: 'today-1days', dateEnd: 'today'},
        {text: '$weekLabel', dateStart: 'today-7days', dateEnd: 'today'},
        {text: '$oneMonthLabel', dateStart: 'today-29days', dateEnd:'today'},
        {
            text: '$currentMonthLabel', 
            dateStart: function() { 
                return Date.parse('today').moveToFirstDayOfMonth();  
            }, 
            dateEnd: 'today' 
        },
        {
            text: '$lastMonthLabel', 
            dateStart: function() { 
                return new Date(new Date().getFullYear(), new Date().getMonth() - 1, 1) 
            },
            dateEnd: function() { 
                return new Date(new Date().getFullYear(), new Date().getMonth(), 0)
            } 
        },
    ],
    presets: {
        dateRange: '$dateRangeLabel'
    },
},$.datepicker.setDefaults($.datepicker.regional['$lang']));
}
$(".drop-date-picker").click(function(){
    $(this).parent().click();
});

$(".ui-daterangepickercontain").prependTo($(".datepicker-drop")); // переносим datepicker в выпадающий список

// fix datepicker links
if ($('.ui-state-default').length > 0) {
    $('.ui-state-default').attr('href', 'javascript:void(0)');
}
if ($('.ui-datepicker-next').length > 0) {
    $('.ui-datepicker-next').attr('href', 'javascript:void(0)');
}
if ($('.ui-datepicker-prev').length > 0) {
    $('.ui-datepicker-prev').attr('href', 'javascript:void(0)');
}
JS;

$this->registerJs($script);
?>
