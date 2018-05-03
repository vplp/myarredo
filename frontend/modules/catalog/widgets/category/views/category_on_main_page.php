<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\{
    Collection, Product, Category, Factory, Types, Specification
};

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>

<div class="categories-sect">
    <div class="container large-container">
        <div class="section-header">

            <h1 class="section-title">
                <?= Yii::t('app', 'Итальянская мебель') . ' ' . Yii::t('app','в') . ' ' . Yii::$app->city->getCityTitleWhere() ?>
            </h1>

            <?= Html::a(
                Yii::t('app', 'Смотреть все категории'),
                Url::toRoute(['/catalog/category/list']),
                ['class' => 'sticker']
            ); ?>
        </div>
        <div class="categories-wrap">
            <?php foreach ($models as $model): ?>
                <div class="one-cat">
                    <div class="one-cat-in">
                        <div class="cat-title">
                            <?= $model['lang']['title']; ?>
                        </div>
                        <a href="<?= Category::getUrl($model['alias']) ?>" class="img-cont">
                            <?= Html::img(Category::getImage($model['image_link'])); ?>
                            <?= Html::img(Category::getImage($model['image_link2']), ['class' => 'is-hover']); ?>
                        </a>

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

                        <a href="<?= Category::getUrl($model['alias']) ?>" class="view-all">
                            Смотреть все
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>