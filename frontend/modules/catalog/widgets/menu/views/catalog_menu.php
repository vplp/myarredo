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
    <li class="js-has-list has-list">
        <?= Html::a(Yii::t('app', 'Catalog of furniture'), ['/catalog/category/list']); ?>
        <div class="list-level-wrap">
            <ul class="list-level">

                <?php foreach ($category as $model): ?>
                    <li>
                        <a href="<?= Category::getUrl($model['alias']) ?>">
                            <div class="img-cont">
                                <img src="" alt="">
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
    <li><?= Html::a(
            Yii::t('app', 'Sale'),
            Url::toRoute(['/catalog/sale/list'])
        ) ?></li>
    <li><?= Html::a(
            Yii::t('app', 'Factory'),
            Url::toRoute(['/catalog/factory/list'])
        ) ?></li>
    <li><?= Html::a(
            Yii::t('app', 'About the project'),
            Url::toRoute(['/page/page/view', 'alias' => 'about'])
        ) ?></li>
    <li><?= Html::a(
            Yii::t('app', 'Contacts in') . ' ' . Yii::$app->city->getCityTitleWhere(),
            Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
        ) ?></li>
</ul>