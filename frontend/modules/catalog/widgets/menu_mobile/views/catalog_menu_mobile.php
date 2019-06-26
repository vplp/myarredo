<?php

use yii\helpers\{
    Html, Url
};
//
use frontend\modules\catalog\models\Category;

/**
 * @var $model Category
 */

?>

<ul class="menu-list">
    <li>
        <?= Html::a(Yii::t('app', 'Catalog of furniture'), ['/catalog/category/list']); ?>
    </li>
    <li>
        <?= Html::a(
            Yii::t('app', 'Sale'),
            Url::toRoute(['/catalog/sale/list'])
        ) ?>
    </li>
    <?php if (Yii::$app->city->domain == 'ru') { ?>
        <li>
            <?= Html::a(
                Yii::t('app', 'Sale in Italy'),
                Url::toRoute(['/catalog/sale-italy/list'])
            ) ?>
        </li>
    <?php } ?>
    <li>
        <?= Html::a(
            Yii::t('app', 'Фабрики'),
            Url::toRoute(['/catalog/factory/list'])
        ) ?>
    </li>
    <li>
        <?= Html::a(
            Yii::t('app', 'About the project'),
            Url::toRoute(['/page/page/view', 'alias' => 'about'])
        ) ?>
    </li>
    <li>
        <?= Html::a(
            Yii::t('app', 'Где купить'),
            Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
        ) ?>
    </li>
</ul>