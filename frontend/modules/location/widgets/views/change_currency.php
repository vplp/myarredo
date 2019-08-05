<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $model \frontend\modules\location\models\Currency
 */

echo Html::a(
    $current['label'] . '<i class="fa fa-chevron-down" aria-hidden="true"></i>',
    'javascript:void(0);',
    ['class' => 'js-select-lang']
); ?>

    <ul class="lang-drop-down">
        <?php foreach ($models as $model) {
            echo Html::tag(
                'li',
                Html::a(
                    $model['label'],
                    $model['url'],
                    ['class' => 'currency-item', 'data-currency' => $model['label']]
                ),
                ['class' => 'currency-selector']
            );
        } ?>
    </ul>

<?php
$url = Url::toRoute('/location/currency/change');
$filter = Yii::$app->request->get('filter');
$script = <<<JS
$('.currency-selector').on('click', '.currency-item', function() {
    var el = $(this);
    var currency = el.data('currency');
    
    $.post('$url',
        {
            _csrf: $('#token').val(),
            currency: currency,
            filter: '$filter'
        }
    ).done(function (data) {
        if (data.link != undefined) {
            document.location.href = data.link;
        } else if (data.success == 1) {
            document.location.reload(true);
        }
    }, 'json');
});
JS;

$this->registerJs($script);
