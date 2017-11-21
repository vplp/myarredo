<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<div class="container large-container">
    <div class="row">
        <div class="col-md-12">
            <div id="comp-slider">

                <?php foreach ($models as $model): ?>

                    <div class="item">
                        <?= Html::beginTag(
                            'a',
                            [
                                'href' => Product::getUrl($model['alias']),
                                'class' => 'tile'
                            ]
                        ); ?>
                        <div class="img-cont">
                            <?= Html::img(Product::getImage($model['image_link'])); ?>
                        </div>
                        <div class="add-item-text">
                            <?= $model['lang']['title']; ?>
                        </div>
                        <?= Html::endTag('a'); ?>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>