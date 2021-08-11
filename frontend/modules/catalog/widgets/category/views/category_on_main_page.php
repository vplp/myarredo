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

                <?php

                switch (DOMAIN_TYPE) {
                    case 'com':
                        $image_link = $model['image_link_com'];
                        break;
                    case 'de':
                        $image_link = $model['image_link_de'];
                        break;
                    case 'fr':
                        $image_link = $model['image_link_fr'];
                        break;
                    default:
                        $image_link = $model['image_link'];
                }

                switch (DOMAIN_TYPE) {
                    case 'com':
                        $image_link2 = $model['image_link2_com'];
                        break;
                    case 'de':
                        $image_link2 = $model['image_link2_de'];
                        break;
                    case 'fr':
                        $image_link2 = $model['image_link2_fr'];
                        break;
                    default:
                        $image_link2 = $model['image_link2'];
                }

                ?>
                <?= Html::a(
                    Html::img('/', [
                        'class' => 'lazy',
                        'data-src' => Category::getImage($image_link),
                        'alt' => $model['lang']['title'],
                        'title' => $model['lang']['title']
                    ])
                    . Html::img('/', [
                        'class' => 'is-hover lazy',
                        'data-src' => Category::getImage($image_link2),
                        'alt' => $model['lang']['title'],
                        'title' => $model['lang']['title']
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
