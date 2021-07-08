<?php

use yii\helpers\Html;

if (!empty($products)) { ?>
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
                                    'href' => $modelClass::getUrl($model[Yii::$app->languages->getDomainAlias()]),
                                    'class' => 'tile',
                                    'target' => '_blank'
                                ]
                            ) ?>

                            <div class="img-cont">
                                <?= Html::img(
                                    $modelClass::getImageThumb($model['image_link']),
                                    [
                                        'loading' => 'lazy',
                                        'width' => '250',
                                        'height' => '250',
                                        'alt' => $model['lang']['title']
                                    ]
                                ) ?>
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
