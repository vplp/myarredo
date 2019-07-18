<?php

use yii\web\View;

/** @var $this \yii\web\View */

?>

<!-- Yandex.Metrika counter -->
<?php if (Yii::$app->city->domain == 'ru') {
    $script = <<<JS
(function () {
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            (function (m, e, t, r, i, k, a) {
                m[i] = m[i] || function () {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
            (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
    
            ym(24814823, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true,
                trackHash: true
            });            
        }, 5000);
    }

    if (d.readyState == 'complete') {
        l();
    } else {
        if (w.attachEvent) {
            w.attachEvent('onload', l);
        } else {
            w.addEventListener('load', l, false);
        }
    }
})();
JS;

    $this->registerJs($script, View::POS_END);
    ?>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/24814823" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
<?php } elseif (Yii::$app->city->domain == 'by') {
    $script = <<<JS
(function () {
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            (function (m, e, t, r, i, k, a) {
                m[i] = m[i] || function () {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
            (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
    
            ym(24880844, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });           
        }, 5000);
    }

    if (d.readyState == 'complete') {
        l();
    } else {
        if (w.attachEvent) {
            w.attachEvent('onload', l);
        } else {
            w.addEventListener('load', l, false);
        }
    }
})();
JS;

    $this->registerJs($script, View::POS_END);
    ?>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/24880844" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
<?php } elseif (Yii::$app->city->domain == 'ua') {
    $script = <<<JS
(function () {
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            (function (m, e, t, r, i, k, a) {
                m[i] = m[i] || function () {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
            (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
    
            ym(39354035, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });           
        }, 5000);
    }

    if (d.readyState == 'complete') {
        l();
    } else {
        if (w.attachEvent) {
            w.attachEvent('onload', l);
        } else {
            w.addEventListener('load', l, false);
        }
    }
})();
JS;

    $this->registerJs($script, View::POS_END);
    ?>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/39354035" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
<?php } ?>
<!-- /Yandex.Metrika counter -->
