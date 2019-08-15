<?php

use yii\helpers\Html;
use frontend\modules\catalog\models\Product;

/**  @var $model Product */

$keys = Yii::$app->catalogFilter->keys;

?>

<?php if (!empty($models)) { ?>
    <div class="rec-slider-wrap">
        <div class="flex c-align rec-header">

            <?= Html::tag(
                'h3',
                Yii::t('app', 'Другие') . ' ' . $types['lang']['plural_name'] . ' ' . $factory['title']
            ); ?>

            <?= Html::a(
                Yii::t('app', 'Показать все'),
                Yii::$app->catalogFilter->createUrl(
                    Yii::$app->catalogFilter->params + [$keys['factory'] => $factory['alias']]
                ),
                ['class' => 'show-more']
            ); ?>

        </div>
        <div class="container large-container">
            <div class="row">
                <div class="std-slider" id="rec2-slider">

                    <?php foreach ($models as $model) { ?>
                        <div class="item" data-dominant-color>
                            <?= Html::beginTag(
                                'a',
                                [
                                    'href' => Product::getUrl($model['alias']),
                                    'class' => 'tile',
                                    'target' => '_blank'
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