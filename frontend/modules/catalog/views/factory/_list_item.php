<?php

use yii\helpers\Html;

/**
 * @var \frontend\modules\catalog\models\Factory $model
 */

?>

<?= Html::beginTag('a', ['href' => $model->getUrl(), 'class' => 'factory-tile']); ?>

    <div class="flex">
        <div class="logo-img">
            <?= Html::img($model->getImageLink()); ?>
        </div>
        <h3><?= $model['lang']['title']; ?></h3>
    </div>
    <object>
        <ul class="assortment">
            <li>
                <a href="#">Кухни</a>
            </li>
            <li>
                <a href="#">Столовые комнаты</a>
            </li>
            <li>
                <a href="#">Стулья</a>
            </li>
            <li>
                <a href="#">Прихожие</a>
            </li>
            <li>
                <a href="#">Кабинеты</a>
            </li>
            <li>
                <a href="#">Мягкая мебель</a>
            </li>
            <li>
                <a href="#">Гостинные</a>
            </li>
            <li>
                <a href="#">Аксессуары</a>
            </li>
            <li>
                <a href="#">Спальни</a>
            </li>
            <li>
                <a href="#">Мебель для ТВ</a>
            </li>
            <li>
                <a href="#">Мебель для ресторанов</a>
            </li>
            <li>
                <a href="#">Двери</a>
            </li>
            <li>
                <a href="#">Светильники</a>
            </li>
        </ul>
    </object>

<?= Html::endTag('a'); ?>