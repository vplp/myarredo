<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var \frontend\modules\catalog\models\Product $model
 */

?>

<?php if (!empty($models)): ?>

    <div class="rec-slider-wrap">
        <div class="flex c-align rec-header">
            <?= Html::tag('h3', 'Другие изделия коллекции ' . $collection['lang']['title']); ?></h3>
            <?= Html::a('Показать все', Yii::$app->catalogFilter->createUrl('collection', $collection['id']), ['class' => 'show-more']); ?>
        </div>
        <div class="container large-container">
            <div class="row">
                <div class="std-slider" id="rec-slider">

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
                                <?= Html::img(Product::getImage()); ?>
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

<?php endif; ?>