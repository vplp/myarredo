<?php

use yii\helpers\{
    Url, Html
};
use frontend\modules\catalog\models\{
    Factory, Product
};
use frontend\modules\banner\widgets\FactoryBanner;

/**
 * @var $model Factory
 * @var $product Product
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
                <?= $model['lang']['content'] ?? '' ?>
            </div>
        </div>
    </div>

    <div class="cat-container">
        <div class="container large-container">

            <?= Html::tag(
                'h3',
                $model['title'] .
                (DOMAIN_TYPE != 'com' ? ' | ' . Yii::t('app', 'Купить в') . ' ' . Yii::$app->city->getCityTitleWhere() : '')
            ); ?>

            <div class="submenu">

                <?php
                $key = 1;
                $FactoryCategory = Factory::getFactoryCategory([$model['id']]);

                foreach ($FactoryCategory as $item) {
                    $params = Yii::$app->catalogFilter->params;

                    $params[$keys['factory']][] = $model['alias'];
                    $params[$keys['category']][] = $item[Yii::$app->languages->getDomainAlias()];

                    echo Html::a(
                        $item['title'],
                        Yii::$app->catalogFilter->createUrl($params)
                    );
                } ?>

            </div>
            <div class="cat-prod">

                <?php
                foreach ($product as $item) {
                    echo $this->render('/category/_list_item', [
                        'model' => $item
                    ]);
                }

                echo Html::a(
                        Yii::t('app', 'Смотреть полный') . '<div>'.Yii::t('app', 'Каталог').'</div>',
                    Yii::$app->catalogFilter->createUrl(
                        [],
                        ['/catalog/template-factory/catalog', 'alias' => $model['alias']]
                    ),
                    ['class' => 'full-cat']
                ); ?>

            </div>
        </div>
    </div>
</div>
