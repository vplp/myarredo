<?php

use yii\web\View;

/** @var $this \yii\web\View */

$this->registerJsFile(
    'https://mc.yandex.ru/metrika/watch.js',
    [
        'position' => View::POS_END,
        'async' => true,
        'defer' => true,
    ]
);

if (Yii::$app->city->domain == 'ru') {
    $script = <<<JS
try {
    var yaCounter24814823 = new Ya.Metrika({
        id:24814823,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
} catch(e) { }
JS;

    $this->registerJs($script, View::POS_END);
    ?>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/24814823" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>

<?php } elseif (Yii::$app->city->domain == 'by') {
    $script = <<<JS
try {
    var yaCounter24880844 = new Ya.Metrika({
        id:24880844,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
} catch(e) { }
JS;

    $this->registerJs($script, View::POS_END);
    ?>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/24880844" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>

<?php } elseif (Yii::$app->city->domain == 'ua') {
    $script = <<<JS
try {
    var yaCounter39354035 = new Ya.Metrika({
        id:39354035,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
} catch(e) { }
JS;

    $this->registerJs($script, View::POS_END);
    ?>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/39354035" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>

<?php } ?>