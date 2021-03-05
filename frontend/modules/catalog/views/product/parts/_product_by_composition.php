<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/** @var $model Product */

?>

<div class="container large-container">
    <div class="row">
        <div class="col-md-12">
            <div id="comp-slider">

                <?php foreach ($models as $model) { ?>
                    <div class="item" data-dominant-color>
                        <?= Html::beginTag(
                            'a',
                            [
                                'href' => Product::getUrl($model[Yii::$app->languages->getDomainAlias()]),
                                'class' => 'tile',
                                'target' => '_blank'
                            ]
                        ); ?>
                        <div class="img-cont">
                            <?= Html::img(Product::getImageThumb($model['image_link']), ['loading' => 'lazy', 'width' => '320', 'height' => '250']); ?>
                            <span class="background"></span>
                        </div>
                        <div class="add-item-text">
                            <?= isset($model['lang']['title']) ? $model['lang']['title'] : ''; ?>
                        </div>
                        <?= Html::endTag('a'); ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
