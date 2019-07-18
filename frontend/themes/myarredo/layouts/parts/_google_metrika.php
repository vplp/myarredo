<?php

use yii\web\View;

/** @var $this \yii\web\View */

/**
 * Global site tag (gtag.js) - Google Analytics
 */

if (Yii::$app->city->domain == 'ru') {
    $script = <<<JS
(function () {
    var widget_id = 'UA-54015829-1';
    var d = document;
    var w = window;

    function l() {
        setTimeout(function () {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = 'https://www.googletagmanager.com/gtag/js?id=' + widget_id;
            var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
            
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-54015829-1');
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


//    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-54015829-1"></script>
//    <script>
//    window.dataLayer = window.dataLayer || [];
//        function gtag(){dataLayer.push(arguments);}
//        gtag('js', new Date());
//        gtag('config', 'UA-54015829-1');
//    </script>

    $this->registerJs($script, View::POS_END);
    ?>
<?php } elseif (Yii::$app->city->domain == 'by') { ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-54015829-4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-54015829-4');
    </script>
<?php } elseif (Yii::$app->city->domain == 'ua') { ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-54015829-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-54015829-3');
    </script>
<?php }

