<?php

use yii\helpers\Html;

?>

<div class="general-slider_i">
    <?php if ($item->lang->link): ?>
        <?= Html::a(Html::img($item->getBannerImage()), $item->lang->link) ?>
    <?php else: ?>
        <?= Html::img($item->getBannerImage()) ?>
    <?php endif; ?>
</div>