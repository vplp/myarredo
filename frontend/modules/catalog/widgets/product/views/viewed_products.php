<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var $model  Product
 */

?>

<?php if (!empty($products)) { ?>
    <div class="rec-slider-wrap">
        <div class="flex c-align rec-header">
            <?= Html::tag('h3', Yii::t('app', 'Viewed products')) ?>
        </div>
        <div class="container large-container">
            <div class="row">
                <div class="std-slider" id="rec-slider">

                    <?php foreach ($products as $model) { ?>
                        <div class="item" data-dominant-color>

                            <?= Html::beginTag(
                                'a',
                                [
                                    'href' => Product::getUrl($model['alias']),
                                    'class' => 'tile'
                                ]
                            ); ?>

                            <div class="img-cont">
                                <?= Html::img(Product::getImageThumb($model['image_link'])); ?>
                                <span class="background"></span>
                            </div>

                            <div class="add-item-text">
                                <?= $model['lang']['title']; ?>
                            </div>

                            <?= Html::endTag('a'); ?>

                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

<?php } ?>
