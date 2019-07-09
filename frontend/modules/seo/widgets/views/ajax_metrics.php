<?php

use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 */

?>

    <div class="novelties"></div>

<?php
$url = Url::to(['/seo/metrics/ajax-get-metrics']);
$script = <<<JS
$.post('$url', {_csrf: $('#token').val()}, function(data){
    $("body").append(data.html);
});
JS;

$this->registerJs($script);