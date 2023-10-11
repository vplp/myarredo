<?php

$this->title = $this->context->title;

$script = <<<JS
window.onload = function() {
    setTimeout(function () {
        document.title = '$this->title';
    }, 1500);
}
JS;

$this->registerJs($script);
