<?php

use yii\helpers\{
    Html, Url
};
use frontend\modules\catalog\models\Category;

/**
 * @var $model \frontend\modules\catalog\models\Category
 */

?>



<div class="categories-sect">
    <div class="container large-container">
        <div class="section-header">

            <h1 class="section-title">
                Итальянская мебель в Москве
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
                        </a>
                        <ul class="cat-list">
                            <li>Кухни <span>169</span></li>
                            <li>Раковины <span>19</span></li>
                            <li>Столы <span>34</span></li>
                            <li>Стулья <span>158</span></li>
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