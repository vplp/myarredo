<?php

use yii\helpers\Html;
use frontend\components\Breadcrumbs;

?>

<main>
    <div class="page about-page">
        <div class="container large-container">
            <div class="col-md-12">
                <?= Html::tag('h1', $this->context->title); ?>
                <?= Breadcrumbs::widget([
                    'links' => $this->context->breadcrumbs,
                    'options' => ['class' => 'bread-crumbs']
                ]) ?>
                <div class="text">

                    <p>Разместив этот небольшой код у себя на сайте, Вы сможете отвечать на поступающие заявки от посетителей нашего сайт. Получая Ваши заявки они могут стать Вашими клиентами.</p>
                    <p>Код для вставки ниже.</p>
                    <p>Партнер сети: &lt;a href=&quot;http://www.myarredo.ru/&quot; target=&quot;_blank&quot;&gt;www.myarredo.ru&lt;/a&gt;</p>

                </div>
            </div>

        </div>
    </div>
</main>