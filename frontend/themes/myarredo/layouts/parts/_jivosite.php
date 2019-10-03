<?php

use yii\web\View;

/** @var $this \yii\web\View */

if (Yii::$app->getUser()->isGuest && Yii::$app->city->domain == 'ru' &&
    !in_array(Yii::$app->controller->id, ['sale', 'sale-italy']) &&
    !in_array(Yii::$app->controller->module->id, ['user'])
) {
    $script = <<<JS
(function () {
    if ($('.cat-prod-sale').length == 0 && $('.yii-debug-toolbar').length == 0) {
        var widget_id = '8vo3Plg4NB';
        var d = document;
        var w = window;
    
        function l() {
            setTimeout(function () {
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = '//code.jivosite.com/script/widget/' + widget_id;
                var ss = document.getElementsByTagName('script')[0];
                ss.parentNode.insertBefore(s, ss);
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
    }
})();
JS;

    $this->registerJs($script, View::POS_END);
}
