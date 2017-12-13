<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\catalog\models\Factory;
use frontend\modules\banner\widgets\banner\FactoryBanner;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 */

$keys = Yii::$app->catalogFilter->keys;

$this->title = $this->context->title;

?>

<div class="tom-cont">

    <div class="container large-container">

        <?= FactoryBanner::widget(['factory_id' => $model['id']]); ?>

    </div>

    <div class="text-description">
        <div class="container large-container">
            <div class="text-col">
                <?= $model['lang']['content'] ?>
            </div>
        </div>
    </div>

    <div class="cat-container">
        <div class="container large-container">
            <?= Html::tag(
                'h3',
                $model['lang']['title'] . ' | Купить в ' . Yii::$app->city->getCityTitleWhere()
            ); ?>
            <div class="submenu">

                <?php
                $key = 1;
                $FactoryCategory = Factory::getFactoryCategory([$model['id']]);

                foreach ($FactoryCategory as $item) {
                    $params = Yii::$app->catalogFilter->params;

                    $params[$keys['factory']][] = $model['alias'];
                    $params[$keys['category']][] = $item['alias'];

                    echo Html::a(
                        $item['title'],
                        Yii::$app->catalogFilter->createUrl($params)
                    );
                } ?>

            </div>
            <div class="cat-prod">

                <?php foreach ($product as $item) {
                    echo $this->render('/category/_list_item', [
                        'model' => $item,
                        'factory' => [$model->id => $model]
                    ]);
                }

                echo Html::a(
                    'смотреть полный<div>Каталог</div>',
                    Yii::$app->catalogFilter->createUrl(
                        Yii::$app->catalogFilter->params + [$keys['factory'] => $model['alias']],
                        ['/catalog/template-factory/catalog', 'alias' => $model['alias']]
                    ),
                    ['class' => 'full-cat']
                ); ?>

            </div>
        </div>
    </div>
</div>
