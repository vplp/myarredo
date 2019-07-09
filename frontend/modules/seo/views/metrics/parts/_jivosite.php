<?php
if (Yii::$app->getUser()->isGuest && Yii::$app->city->domain == 'ru' &&
    !in_array(Yii::$app->controller->id, ['sale']) &&
    !in_array(Yii::$app->controller->module->id, ['user'])
) { ?>
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script src="//code3.jivosite.com/widget.js" jv-id="8vo3Plg4NB" async></script>
    <!-- {/literal} END JIVOSITE CODE -->
<?php } ?>