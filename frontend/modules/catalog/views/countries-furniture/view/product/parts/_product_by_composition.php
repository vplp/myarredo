<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\{
    Product, CountriesFurniture
};

/** @var $model Product */

?>
<?php if (!empty($models)) { ?>
    <div class="container large-container">
        <div class="row">
            <div class="col-md-12">
                <div id="comp-slider">

                    <?php foreach ($models as $model) { ?>
                        <div class="item" data-dominant-color>
                            <?= Html::beginTag(
                                'a',
                                [
                                    'href' => CountriesFurniture::getUrl($model['alias']),
                                    'class' => 'tile',
                                    'target' => '_blank'
                                ]
                            ); ?>
                            <div class="img-cont">
                                <?= Html::img(Product::getImageThumb($model['image_link']), ['loading' => 'lazy']); ?>
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
