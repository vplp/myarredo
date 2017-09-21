<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\Breadcrumbs;

$this->context->breadcrumbs[] = [
    'label' => $this->context->label
];

?>

<div class="basket-page page">
    <div class="cont">
        <div class="bread-crumbs">
            <?= Breadcrumbs::widget([
                'homeLink' => [
                    'label' => Yii::t('yii', 'Home'),
                    'url' => \yii\helpers\Url::toRoute(['/home/home/index'])
                ],
                'links' => $this->context->breadcrumbs
            ]) ?>
        </div>

        <?= Html::tag('h2', $this->context->label) ?>

        Вы еще не добавили в заказ товаров.

    </div>
</div>