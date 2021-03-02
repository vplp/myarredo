<?php

$this->title = $this->context->title;

$script = <<<JS
setTimeout(function () {
    document.title = '$this->title';
}, 500);
JS;

$this->registerJs($script);
