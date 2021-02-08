<?php

use yii\helpers\{
    Html, Url
};

//
use frontend\modules\catalog\models\{
    Category, Types
};

/**
 * @var $models Category[]
 * @var $model Category
 */

?>

<div class="categories-wrap">
    <?php foreach ($models as $model) { ?>
        <div class="one-cat">
            <div class="one-cat-in">
                <div class="cat-title">
                    <?= $model['lang']['title']; ?>
                </div>
                <?= Html::a(
                    Html::img('/', [
                        'class' => 'lazy',
                        'data-src' => Category::getImage(DOMAIN_TYPE != 'com' ? $model['image_link'] : $model['image_link_com'])
                    ])
                    . Html::img('/', [
                        'class' => 'is-hover lazy',
                        'data-src' => Category::getImage(DOMAIN_TYPE != 'com' ? $model['image_link2'] : $model['image_link2_com'])
                    ]),
                    Category::getUrl($model[Yii::$app->languages->getDomainAlias()]),
                    ['class' => 'img-cont']
                ) ?>
                <ul class="cat-list">
                    <?php
                    $keys = Yii::$app->catalogFilter->keys;
                    $params = Yii::$app->catalogFilter->params;

                    $params[$keys['category']] = $model[Yii::$app->languages->getDomainAlias()];

                    $link = Yii::$app->catalogFilter->createUrl($params, ['/catalog/category/list']);

                    echo '<li>' . Html::a($model['lang']['title'], $link) . '<span>' . $model['count'] . '</span></li>';

                    $types = Types::getWithProduct($params);

                    foreach ($types as $item) {
                        $params = Yii::$app->catalogFilter->params;

                        $params[$keys['category']] = $model[Yii::$app->languages->getDomainAlias()];
                        $params[$keys['type']][] = $item[Yii::$app->languages->getDomainAlias()];
                        $link = Yii::$app->catalogFilter->createUrl($params, ['/catalog/category/list']);

                        echo '<li>' . Html::a($item['lang']['title'] ?? '', $link) . '<span>' . $item['count'] . '</span></li>';
                    }
                    ?>
                </ul>
                <?= Html::a(
                    Yii::t('app', 'Смотреть все'),
                    Category::getUrl($model[Yii::$app->languages->getDomainAlias()]),
                    ['class' => 'view-all']
                ) ?>
            </div>
        </div>
    <?php } ?>
</div>
