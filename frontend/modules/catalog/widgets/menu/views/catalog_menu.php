<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu"
            aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<div class="collapse navbar-collapse" id="main-menu">
    <ul class="nav navbar-nav">
        <li>
            <?= Html::a(Yii::t('app', 'Catalog of furniture'), ['/catalog/category/list']); ?>
            <div class="dropdown-item">
                <div class="container large-container">
                    <ul class="drop-down-list">

                        <?php foreach ($category as $model):
                            echo Html::beginTag('li')
                                . Html::a($model['lang']['title'] . ' (' . $model['count'] . ')', Category::getUrl($model['alias']))
                                . Html::endTag('li');
                            //
                            (isset($i)) ? $i++ : $i = 1;
                            //
                            if ($i % 6 == 0):
                                echo '</ul><ul class="drop-down-list">';
                            endif;
                        endforeach; ?>

                    </ul>
                </div>
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

</div>