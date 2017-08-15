<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?= Html::beginTag('a', ['href' => Product::getUrl($model['alias']), 'class' => 'one-prod-tile']); ?>

    <object>
        <div href="javascript:void(0);" class="request-price">
            Запросить цену
        </div>
    </object>
    <div class="img-cont">
        <?= Html::img(Product::getImage()); ?>
        <div class="brand">
            <?= (isset($factory[$model['factory_id']])) ? $factory[$model['factory_id']]['lang']['title'] : null; ?>
        </div>
    </div>
    <div class="item-infoblock">
        <?= Product::getTitle(
                $model,
                isset($types[$model['catalog_type_id']]) ? $types[$model['catalog_type_id']] : null,
            isset($collection[$model['collections_id']]) ? $collection[$model['collections_id']] : null
        ); ?>
    </div>

<?= Html::endTag('a'); ?>