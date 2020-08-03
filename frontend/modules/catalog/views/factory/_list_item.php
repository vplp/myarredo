<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Factory;

/**
 * @var Factory $model
 */

$keys = Yii::$app->catalogFilter->keys;

?>

<?= Html::beginTag(
    'a',
    [
        'href' => Factory::getUrl($model['alias']),
        'class' => 'factory-tile'
    ]
); ?>

<div class="flex column-direction">
    <div class="logo-img">
        <?= Html::img('/', [
            'class' => 'lazy',
            'data-src' => Factory::getImageThumb($model['image_link'])
        ]); ?>
    </div>
    <?= Html::tag('h2', $model['title']); ?>
</div>

<object>
    <ul class="assortment">
        <?php
        foreach ($categories as $item) {
            echo Html::beginTag('li') .
                Html::a(
                    $item['title'],
                    Yii::$app->catalogFilter->createUrl(
                        Yii::$app->catalogFilter->params +
                        [$keys['category'] => $item[Yii::$app->languages->getDomainAlias()]] +
                        [$keys['factory'] => $model['alias']]
                    )
                ) .
                Html::endTag('li');
        } ?>
    </ul>
</object>

<?= Html::endTag('a'); ?>
