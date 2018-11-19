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
    Фабрика: <?= Html::a($model->factory['title'], Factory::getUrl($model->factory['alias'])) ?>
</p>
<p>
    Товары:<br>
    <?php
    $result = [];
    foreach ($model->products as $product) {
        $result[] = Html::a($product->lang->title, Product::getUrl($product['alias']));
    }
    echo implode(', ', $result);
    ?>
</p>
<p>
    Страна: <?= $model->country->lang->title ?>
</p>
<p>
    Города:
    <?php
    $result = [];
    foreach ($model->cities as $city) {
        $result[] = $city->lang->title;
    }
    echo implode(', ', $result);
    ?>
</p>
<p>
    Дата оплаты: <?= date('j.m.Y', $model->updated_at) ?>
</p>
