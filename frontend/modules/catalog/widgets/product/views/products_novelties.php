<?php

use yii\helpers\Html;

if (!empty($products)) { ?>
    <div class="rec-slider-wrap novetly-sliderbox">
        <div class="container large-container">
            <div class="row">
                <div class="std-slider" id="rec-slider">

                    <?php foreach ($products as $model) { ?>
                        <div class="item" data-dominant-color>

                            <?= Html::beginTag(
                                'a',
                                [
                                    'href' => $modelClass::getUrl($model['alias']),
                                    'class' => 'tile'
                                ]
                            ) ?>

                            <div class="img-cont">
                                <?= Html::img($modelClass::getImageThumb($model['image_link'])) ?>
                                <span class="background"></span>
                            </div>

                            <div class="add-item-text">
                                <?= $model['lang']['title'] ?>
                            </div>

                            <?= Html::endTag('a') ?>

                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
<?php }
