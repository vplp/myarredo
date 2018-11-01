<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Factory;
use frontend\modules\catalog\models\{
    FactoryPromotion, Product, FactoryProduct, FactoryPromotionRelProduct
};

/* @var $this yii\web\View */

/**
 * @var \frontend\modules\catalog\models\FactoryPromotion $model
 * @var \frontend\modules\catalog\models\FactoryProduct $modelProduct
 */

?>

<p><?= $message ?></p>
<p><?= $title ?></p>
<p><?= $url ?></p>
<p>
    <!-- Название фабрики, Ссылку на страницу фабрики -->
    Название фабрики: <?= Html::a($model->factory['title'], Factory::getUrl($model->factory['alias'])) ?>
</p>
<p>
    <!-- Список рекламируемых товаров в формате списка (в строке название товара и ссылка на товар) -->
    Список рекламируемых товаров:<br>
    <?php
    foreach ($model->products as $product) {
        echo Html::a($product->lang->title, Product::getUrl($product['alias'])) . '<br>';
    } ?>
</p>
<p>
    <!-- Страна рекламной компании -->
    Страна рекламной компании: <?= $model->country->lang->title ?>
</p>
<p>
    <!-- Города рекламной компании -->
    Города рекламной компании:<br>
    <?php
    foreach ($model->cities as $city) {
        echo $city->lang->title . '<br>';
    }
    ?>
</p>

<!-- Количество просмотров рекламной компании -->

<p>
    <!-- Дата оплаты рекламной компании -->
    Дата оплаты рекламной компании: <?= date('j.m.Y', $model->updated_at) ?>
</p>
