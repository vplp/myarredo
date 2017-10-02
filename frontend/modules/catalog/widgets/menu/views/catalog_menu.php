<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

$session = Yii::$app->session;

?>

<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
</div>
<div class="collapse navbar-collapse" id="main-menu">
    <ul class="nav navbar-nav">
        <li>
            <?= Html::a('Каталог мебели', ['/catalog/category/list']); ?>
            <div class="dropdown-item">
                <div class="container large-container">
                    <ul class="drop-down-list">

                        <?php foreach ($category as $model): ?>
                            <li><?= Html::a($model['lang']['title'], Category::getUrl($model['alias'])); ?></li>
                            <?php
                            (isset($i)) ? $i++ : $i = 1;
                            if ($i % 6 == 0)
                                echo '</ul><ul class="drop-down-list">';
                            ?>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </li>
        <li><?= Html::a(
                'Фабрики',
                Url::toRoute(['/catalog/factory/list'])
            ); ?></li>
        <li><?= Html::a(
                'Распродажа',
                Url::toRoute(['/catalog/sale/list'])
            ); ?></li>
        <li><?= Html::a(
                'О проекте',
                Url::toRoute(['/page/page/view', 'alias' => 'about'])
            ); ?></li>
        <li><?= Html::a(
                'Контакты в ' . $session['city']['lang']['title_where'],
                Url::toRoute(['/page/page/view', 'alias' => 'contacts'])
            ); ?></li>
    </ul>

</div>