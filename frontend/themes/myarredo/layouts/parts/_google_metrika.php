<?php

use yii\web\View;

/** @var $this \yii\web\View */

/**
 * Global site tag (gtag.js) - Google Analytics
 */
$show = !isset($_COOKIE["cookie_agree"]) || $_COOKIE["cookie_agree"] == "1";
if (DOMAIN_TYPE == 'ru') {
    $script = <<<JS
(function () {
    var id = 'UA-54015829-1';
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=' + id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
            
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', id);
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
} elseif (DOMAIN_TYPE == 'by') {
    $script = <<<JS
(function () {
    var id = 'UA-54015829-4';
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=' + id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
            
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', id);
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
} elseif (DOMAIN_TYPE == 'ua') {
    $script = <<<JS
(function () {
    var id = 'UA-54015829-3';
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=' + id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
            
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', id);
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
} elseif (DOMAIN_TYPE == 'com' && $show) {
    $script = <<<JS
(function () {
    var id = 'UA-54015829-2';
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=' + id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
            
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', id);
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
}
