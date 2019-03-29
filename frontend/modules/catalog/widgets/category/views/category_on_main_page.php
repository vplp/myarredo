<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Category, Types
};

/**
 * @var $model \frontend\modules\catalog\models\Category
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
                    Html::img(Category::getImage($model['image_link'])) .
                    Html::img(Category::getImage($model['image_link2']), ['class' => 'is-hover']),
                    Category::getUrl($model['alias']),
                    ['class' => 'img-cont']
                ) ?>
                <ul class="cat-list">
                    <?php
                    $keys = Yii::$app->catalogFilter->keys;
                    $params = Yii::$app->catalogFilter->params;

                    $params[$keys['category']] = $model['alias'];

                    $types = Types::getWithProduct($params);

                    foreach ($types as $item) {
                        $params = Yii::$app->catalogFilter->params;

                        $params[$keys['category']] = $model['alias'];
                        $params[$keys['type']][] = $item['alias'];
                        $link = Yii::$app->catalogFilter->createUrl($params, ['/catalog/category/list']);

                        echo '<li>' . Html::a($item['lang']['title'], $link) . '<span>' . $item['count'] . '</span></li>';
                    }
                    ?>
                </ul>
                <?= Html::a(
                    Yii::t('app', 'Смотреть все'),
                    Category::getUrl($model['alias']),
                    ['class' => 'view-all']
                ) ?>
            </div>
        </div>
    <?php } ?>
</div>
