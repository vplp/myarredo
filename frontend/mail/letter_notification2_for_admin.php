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
    <div style="background-color: #c4c0b8; padding:15px 0; text-align:center;">
        <div>
            <?= Html::img(
                'https://www.myarredo.ru/uploads/mailer/logo_note.png'
            ) ?>
        </div>
        <div>
            <span style="color: #fff; font:bold 16px Arial,sans-serif;">
                Мы помогаем купить мебель по лучшим ценам.
            </span>
        </div>
    </div>
    <div style="background-color:#fff9ea; text-align: left; padding: 10px 0 40px 10px;">

        <p><?= $title ?></p>
        <p><?= $message ?></p>
        <p><?= $url ?></p>
        <p>
            Фабрика: <?= Html::a($model->factory['title'], Factory::getUrl($model->factory['alias'])) ?>
        </p>
        <p>
            Товары:<br>
            <?php
            $result = [];
            foreach ($model->products as $product) {
                $result[] = Html::a($product->lang->title, Product::getUrl($product[Yii::$app->languages->getDomainAlias()]));
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
