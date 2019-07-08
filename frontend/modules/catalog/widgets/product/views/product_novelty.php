<?php

use yii\helpers\Url;

/**
 * @var $this \yii\web\View
 */

?>

    <div class="novelties"></div>

<?php
$url = Url::to(['/catalog/category/ajax-get-novelty']);
$script = <<<JS
    $.post('$url', {_csrf: $('#token').val()}, function(data){
        $('.novelties').html(data.html);
    });
JS;

$this->registerJs($script);