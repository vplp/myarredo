<?php

use yii\helpers\Html;

?>

<?= Html::a(
    '<i class="fa fa-globe" aria-hidden="true"></i>' .
    $current['label'] .
    '<i class="fa fa-chevron-down" aria-hidden="true"></i>',
    'javascript:void(0);',
    ['class' => 'js-select-lang']
) ?>

<ul class="lang-drop-down">
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
