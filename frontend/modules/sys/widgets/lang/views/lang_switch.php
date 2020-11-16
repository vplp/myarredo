<?php

use yii\helpers\Html;
use frontend\modules\sys\models\Language;

/** @var $current Language */
/** @var $models Language */
/** @var $model Language */

?>

<?= Html::a(
    $current['image'] . '&nbsp;' . $current['label'] .
    '<i class="fa fa-chevron-down" aria-hidden="true"></i>',
    'javascript:void(0);',
    ['class' => 'js-select-lang']
) ?>

<ul class="lang-drop-down">
    <?php
    $options = [];

    $tags = get_meta_tags('https://' . DOMAIN_NAME . '.' . DOMAIN_TYPE . Yii::$app->request->url);
    if (strpos($tags['robots'], 'noindex') !== false) {
        $options['rel'] = 'nofollow';
    }

    foreach ($models as $model) {
        if ($model['alias'] == $current['alias']) {
            continue;
        }

        echo Html::tag(
            'li',
            Html::a(
                $model['image'] . '&nbsp;' . $model['label'],
                $model['url'],
                $options
            )
        );
    } ?>
</ul>
