<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>

<ul class="menu-list">
    <li>
        <?= Html::a(Yii::t('app', 'Catalog of furniture'), ['/catalog/category/list']); ?>
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
            Yii::t('app', 'Contacts') /*. ' ' . Yii::$app->city->getCityTitleWhere()*/,
            Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
        ) ?></li>
</ul>