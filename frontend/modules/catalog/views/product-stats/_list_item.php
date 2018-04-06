<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?= Html::beginTag('a', [
    'href' => Url::toRoute(['/catalog/product-stats/view', 'id' => $model['product']['id']]),
    'class' => 'one-prod-tile'
]); ?>

    <div class="img-cont">

        <?= Html::img(Product::getImageThumb($model['product']['image_link'])) ?>

        <div class="brand"><?= $model['views'] ?></div>

    </div>

    <div class="item-infoblock">
        <?= Product::getStaticTitle($model['product']) ?>
    </div>

<?= Html::endTag('a'); ?>