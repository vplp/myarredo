<?php
use yii\helpers\Url;

/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
?>
<iframe onload="autoResize(this);" class="iframebox" src="<?= Url::toRoute($link) ?>"
        style="width: 100%; border: 0; height: 10px;">
</iframe>
<script type="text/javascript">
    function autoResize(iframe) {
        console.log($(iframe).contents().find('#wrapper').height());
        $(iframe).height($(iframe).contents().find('#wrapper').height());
    }
</script>