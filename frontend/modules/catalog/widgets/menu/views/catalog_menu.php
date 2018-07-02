<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>


<ul class="navigation">
    <li<?= (Yii::$app->controller->id == 'category') ? ' class="js-has-list has-list"': ' class="js-has-list"' ?>>
        <?= Html::a(Yii::t('app', 'Catalog of furniture'), ['/catalog/category/list']); ?>
        <div class="list-level-wrap">
            <ul class="list-level">

                <?php foreach ($category as $model): ?>
                    <li>
                        <a href="<?= Category::getUrl($model['alias']) ?>">
                            <div class="img-cont">
                                <?= Html::img(Category::getImage($model['image_link3'])); ?>
                            </div>
                            <?= $model['lang']['title'] ?>
                        </a>
                        <span class="count">
                            <?= $model['count'] ?>
                        </span>
                    </li>
                    <?php
                endforeach; ?>

            </ul>
        </div>
    </li>
    <li<?= (Yii::$app->controller->id == 'sale' ) ? ' class="has-list"': '' ?>><?= Html::a(
            Yii::t('app', 'Sale'),
            Url::toRoute(['/catalog/sale/list'])
        ) ?></li>
    <li<?= (Yii::$app->controller->id == 'factory' ) ? ' class="has-list"': '' ?>><?= Html::a(
            Yii::t('app', 'Фабрики'),
            Url::toRoute(['/catalog/factory/list'])
        ) ?></li>
    <li<?= (Yii::$app->controller->id == 'page' && Yii::$app->request->get('alias') == 'about') ? ' class="has-list"': '' ?>><?= Html::a(
            Yii::t('app', 'About the project'),
            Url::toRoute(['/page/page/view', 'alias' => 'about'])
        ) ?></li>
    <li<?= (Yii::$app->controller->id == 'contacts') ? ' class="has-list"': '' ?>><?= Html::a(
            Yii::t('app', 'Contacts') /*. ' ' . Yii::$app->city->getCityTitleWhere()*/,
            Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
        ) ?></li>
</ul>