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
                                    'class' => 'tile',
                                    'target' => '_blank'
                                ]
                            ) ?>

                            <?php if ($model['bestseller']) { ?>
                                <div class="prod-bestseller"><?= Yii::t('app', 'Bestseller') ?></div>
                            <?php } ?>

                            <?php if ($modelClass::getSavingPrice($model)) { ?>
                                <div class="prod-saving-percentage"><?= $modelClass::getSavingPercentage($model) ?></div>
                            <?php } ?>

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
