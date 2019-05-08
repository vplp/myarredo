<?php

use yii\helpers\Html;
//
use frontend\modules\catalog\models\Factory;
use frontend\modules\catalog\models\{
    FactoryPromotion, Product, FactoryProduct, FactoryPromotionRelProduct
};

/* @var $this yii\web\View */

/* @var $title string */
/* @var $message string */
/* @var $url string */

/**
 * @var $model FactoryPromotion
 * @var $modelProduct FactoryProduct
 */

?>

<div style="width:540px; font: 16px Arial,sans-serif;">
    <div style="background:#c4c0b8 url('https://www.myarredo.ru/uploads/mailer/logo_note.png') center 10px no-repeat; height: 35px;  padding-top:45px; text-align:center;">
        <span style="color: #fff; font:bold 16px Arial,sans-serif;">
            <?= Yii::t('app', 'Мы помогаем купить итальянскую мебель по лучшим ценам.') ?>
        </span>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">

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
    </div>
</div>