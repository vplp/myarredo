<?php

use yii\web\View;

/** @var $this \yii\web\View */

if (Yii::$app->city->getJivosite()) {
    echo ' <script src="' . Yii::$app->city->getJivosite() . '" async></script>';
}
/*
?>

<?php if (DOMAIN_TYPE == 'com') { ?>
    <script src="//code.jivosite.com/widget/j8ehoc0YLd" async></script>
<?php } elseif (in_array(Yii::$app->city->getCityId(), [5]) && Yii::$app->getUser()->isGuest) { ?>
    <script src="//code.jivosite.com/widget/yG6Q733QpB" async></script>
<?php } elseif (in_array(Yii::$app->city->getCityId(), [38])) { ?>
    <script src="//code-ya.jivosite.com/widget/BCBRXDDEBZ" async></script>
<?php } elseif (in_array(Yii::$app->city->getCityId(), [89])) { ?>
    <script src="//code-ya.jivosite.com/widget/7RaHzlV7fb" async></script>
<?php } elseif (in_array(Yii::$app->city->getCityId(), [44])) { ?>
    <script src="//code-ya.jivosite.com/widget/4GPT8DHdeo" async></script>
<?php } elseif (in_array(Yii::$app->city->getCityId(), [47])) { ?>
    <script src="//code-ya.jivosite.com/widget/93COR0jvXn" async></script>
<?php } elseif (in_array(Yii::$app->city->getCityId(), [45])) { ?>
    <script src="//code-ya.jivosite.com/widget/0wbN9wW6Ah" async></script>
<?php } elseif (Yii::$app->getUser()->isGuest && DOMAIN_TYPE == 'ru' &&
    !in_array(Yii::$app->controller->id, ['sale', 'sale-italy']) &&
    !in_array(Yii::$app->controller->module->id, ['user']) &&
    in_array(Yii::$app->city->getCityId(), [28])
) { ?>
    <script src="//code-ya.jivosite.com/widget/2VVsqQPfCV" async></script>
<?php } elseif (Yii::$app->getUser()->isGuest && DOMAIN_TYPE == 'ru' &&
    !in_array(Yii::$app->controller->id, ['sale', 'sale-italy']) &&
    !in_array(Yii::$app->controller->module->id, ['user']) &&
    !in_array(Yii::$app->city->getCityId(), [4])
) { ?>
    <script src="//code.jivosite.com/widget/bdFHrCDC3S" async></script>
<?php }

if (Yii::$app->getUser()->isGuest && DOMAIN_TYPE == 'ru' &&
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
*/
