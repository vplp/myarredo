<?php

use yii\helpers\Html;

?>
<div class="one-list js-toggle-list">
    <i class="fa fa-globe" aria-hidden="true"></i>
    <?= $current['label'] ?>
</div>
<ul class="mobile-lang-list js-list-container">
    <?php
    foreach ($models as $model) {
        if ($model['alias'] == $current['alias']) {
            continue;
        }
        echo Html::tag(
            'li',
            Html::a(
                '<i class="fa fa-globe" aria-hidden="true"></i>' . $model['label'],
                $model['url'],
                []
            )
        );
    } ?>
</ul>