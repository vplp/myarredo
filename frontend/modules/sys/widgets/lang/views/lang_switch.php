<?php

use yii\helpers\Html;
use frontend\modules\sys\models\Language;

/** @var $noIndex boolean */
/** @var $current Language */
/** @var $models Language */
/** @var $model Language */

?>

<?= Html::a(
    $current['image'] . '&nbsp;' .
    '<i class="fa fa-chevron-down" aria-hidden="true"></i>',
    'javascript:void(0);',
    ['class' => 'js-select-lang']
) ?>

<ul class="lang-drop-down">
    <?php
    $options = [];

    if ($noIndex) {
        $options['rel'] = 'nofollow';
    }

    foreach ($models as $model) {
        if ($model['alias'] == $current['alias']) {
            continue;
        }

        echo Html::tag(
            'li',
            Html::a(
                $model['image'],
                $model['url'],
                $options
            )
        );
    } ?>
</ul>
