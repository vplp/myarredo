<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model Category
 * @var $category Category
 * @var $categorySale Category
 * @var $categorySaleItaly Category
 */

?>

<ul class="navigation headermenu">
    <li <?= (Yii::$app->controller->id == 'category') ? ' class="js-has-list first-link"' : ' class="js-has-list first-link"' ?>>
        <?= Html::a(Yii::t('app', 'Catalog of furniture'), ['/catalog/category/list']); ?>
        <div class="list-level-wrap">
            <ul class="list-level">

                <?php foreach ($category as $model) { ?>
                    <li>
                        <a href="<?= Category::getUrl($model[Yii::$app->languages->getDomainAlias()]) ?>">
                            <div class="img-cont">
                                <?= Html::img(Category::getImage($model['image_link3'])); ?>
                            </div>
                            <?= $model['lang']['title'] ?>
                        </a>
                        <span class="count">
                            <?= $model['count'] ?>
                        </span>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </li>

    <?php if (!in_array(DOMAIN_TYPE, ['com', 'de', 'fr', 'kz', 'co.il'])) { ?>
        <li <?= (Yii::$app->controller->id == 'sale') ? ' class="js-has-list second-link"' : ' class="js-has-list second-link"' ?>>
            <?= Html::a(
                Yii::t('app', 'Sale'),
                Url::toRoute(['/catalog/sale/list'])
            ) ?>

            <div class="list-level-wrap">
                <ul class="list-level">

                    <?php foreach ($categorySale as $model) { ?>
                        <li>
                            <a href="<?= Category::getUrl($model[Yii::$app->languages->getDomainAlias()], '/catalog/sale/list') ?>">
                                <div class="img-cont">
                                    <?= Html::img(Category::getImage($model['image_link3'])); ?>
                                </div>
                                <?= $model['lang']['title'] ?>
                            </a>
                            <span class="count">
                            <?= $model['count'] ?>
                        </span>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </li>
    <?php } ?>

    <?php /*
    <li <?= (Yii::$app->controller->id == 'sale-italy') ? ' class="js-has-list has-list third-link"' : ' class="js-has-list third-link"' ?>>
        <?= Html::a(
            Yii::t('app', 'Sale in Italy'),
            Url::toRoute(['/catalog/sale-italy/list'])
        ) ?>

        <div class="list-level-wrap">
            <ul class="list-level">

                <?php foreach ($categorySaleItaly as $model) { ?>
                    <li>
                        <a href="<?= Category::getUrl($model[Yii::$app->languages->getDomainAlias()], '/catalog/sale-italy/list') ?>">
                            <div class="img-cont">
                                <?= Html::img(Category::getImage($model['image_link3'])); ?>
                            </div>
                            <?= $model['lang']['title'] ?>
                        </a>
                        <span class="count">
                            <?= $model['count'] ?>
                        </span>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </li>
*/ ?>

    <li <?= (Yii::$app->controller->id == 'factory') ? ' class="has-list"' : '' ?>>
        <?= Html::a(
            Yii::t('app', 'Фабрики'),
            Url::toRoute(['/catalog/factory/list'])
        ) ?>
    </li>

    <?php if (!in_array(DOMAIN_TYPE, ['kz'])) { ?>
        <li <?= (Yii::$app->controller->id == 'contacts') ? ' class="has-list"' : '' ?>>
            <?= Html::a(
                Yii::t('app', 'Где купить'),
                Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
            ) ?>
        </li>
    <?php } ?>
</ul>
