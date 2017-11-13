<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?= Html::beginTag('a', ['href' => Product::getUrl($model['alias']), 'class' => 'one-prod-tile']); ?>

<?php if (!$model['removed']): ?>
    <object>
        <div class="request-price" data-id=<?= $model['id'] ?> data-toggle="modal" data-target="#myModal">
            Запросить цену
        </div>
    </object>
<?php endif; ?>

    <div class="img-cont">
        <?= Html::img(Product::getImage($model['image_link'])); ?>
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