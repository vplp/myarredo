<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $model \frontend\modules\location\models\Currency
 */

?>
<div class="one-list js-toggle-list">
    <?= $current['label'] ?>
</div>
<ul class="mobile-lang-list js-list-container">
    <?php foreach ($models as $model) {
        echo Html::tag(
            'li',
            Html::a(
                $model['label'],
                $model['url'],
                ['class' => 'mobile-currency-item', 'data-currency' => $model['label']]
            ),
            ['class' => 'mobile-currency-selector']
        );
    } ?>
</ul>

<?php
$url = Url::toRoute('/location/currency/change');
$script = <<<JS
$('.mobile-currency-selector').on('click', '.mobile-currency-item', function() {
    var el = $(this);
    var currency = el.data('currency');
    
    $.post('$url',
        {
            _csrf: $('#token').val(),
            currency: currency
        }
    ).done(function (data) {
        if (data.success == 1) {
            document.location.reload(true);
        }
    }, 'json');
});
JS;

$this->registerJs($script);