<?php

use yii\helpers\Html;

$script = <<<JS
grecaptcha.ready(function() {
   grecaptcha.execute('{$site_key}', {action: '{$actionName}'}).then(function(token) {
       $('#{$inputId}').val(token);
   });
});

$('#{$formId}').on('beforeSubmit',function(){
    if(!$('#{$inputId}').val()){
       grecaptcha.ready(function() {
           grecaptcha.execute('{$site_key}', {action: '{$actionName}'}).then(function(token) {
               $('#{$inputId}').val(token);
               $('#{$formId}').submit();
           });
       });
       return false;
    } else {
       return true;
    }
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);

echo Html::activeHiddenInput($model, $attribute, ['value' => '']);
