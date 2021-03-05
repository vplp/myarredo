<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**
 * @var $modelProduct
 * @var $model Product
 */
$keys = Yii::$app->catalogFilter->keys;

?>

<?php if (!empty($models) && $collection) { ?>
    <div class="rec-slider-wrap">
        <div class="flex c-align rec-header">

            <?= Html::tag(
                'h3',
                Yii::t('app', 'Другие изделия коллекции') .
                ' ' .
                $collection['title']
            ); ?>

            <?= Html::a(
                Yii::t('app', 'Показать все'),
                Yii::$app->catalogFilter->createUrl(
                    Yii::$app->catalogFilter->params + [$keys['collection'] => $collection['id']]
                ),
                ['class' => 'show-more']
            ); ?>

        </div>
        <div class="container large-container">
            <div class="row">
                <div class="std-slider" id="rec-slider">

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
                                <?= Html::img(Product::getImageThumb($model['image_link']), ['loading' => 'lazy', 'width' => '250', 'height' => '250'],); ?>
                                <span class="background"></span>
                            </div>

                            <div class="add-item-text">
                                <?= isset($model['lang']) ? $model['lang']['title'] : ''; ?>
                            </div>

                            <?= Html::endTag('a'); ?>

                        </div>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
<?php } ?>
