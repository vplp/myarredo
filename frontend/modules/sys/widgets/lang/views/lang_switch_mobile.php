<?php

use yii\helpers\Html;
use frontend\modules\sys\models\Language;

/** @var $current Language */
/** @var $models Language */
/** @var $model Language */

?>
<div class="one-list js-toggle-list">
    <?= $current['image'] . '&nbsp;' . $current['label'] ?>
</div>
<ul class="mobile-lang-list js-list-container">
    <?php foreach ($models as $model) {
        if ($model['alias'] == $current['alias']) {
            continue;
        }
        echo Html::tag(
            'li',
            Html::a(
                $model['image'] . '&nbsp;' . $model['label'],
                $model['url'],
                []
            )
        );
    } ?>
</ul>
