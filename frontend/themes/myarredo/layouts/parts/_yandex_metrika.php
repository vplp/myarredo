<?php

use yii\web\View;

/** @var $this \yii\web\View */

/**
 * Yandex.Metrika counter
 */

if (DOMAIN_TYPE == 'ru') {
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
        <div><img src="https://mc.yandex.ru/watch/24814823" alt=""/></div>
    </noscript>
<?php } elseif (DOMAIN_TYPE == 'by') {
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
        <div><img src="https://mc.yandex.ru/watch/24880844" alt=""/></div>
    </noscript>
<?php } elseif (DOMAIN_TYPE == 'ua') {
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
        <div><img src="https://mc.yandex.ru/watch/39354035" alt=""/></div>
    </noscript>
<?php } elseif (DOMAIN_TYPE == 'com') {
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
    
           ym(54688942, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true
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
        <div><img src="https://mc.yandex.ru/watch/54688942" alt="" /></div>
    </noscript>
<?php }
