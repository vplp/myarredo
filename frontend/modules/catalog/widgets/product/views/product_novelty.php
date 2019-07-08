<?php

use yii\helpers\Url;

?>

<div class="novelties"></div>

<?php
$url = Url::to(['/catalog/category/ajax-get-novelty']);
$script = <<<JS
$(window).bind("load", function() {
    $.post('$url', {_csrf: $('#token').val()}, function(data){
        $('.novelties').html(data.html);
    });
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);