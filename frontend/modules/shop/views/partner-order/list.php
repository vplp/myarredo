<?php

use yii\helpers\{
    Html, Url
};
use yii\widgets\ActiveForm;

/**
 * @var \frontend\modules\shop\models\Order $model
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= Html::tag('h1', $this->context->title); ?>

            <!--
            <form class="form-filter-date-cont flex">
                <div class="dropdown arr-drop">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Россия</button>
                    <ul class="dropdown-menu drop-down-find">
                        <li>
                            <input type="text" class="find">
                        </li>
                        <li>
                            <a href="#">Россия</a>
                        </li>
                        <li>
                            <a href="#">Украина</a>
                        </li>
                        <li>
                            <a href="#">Беларусь</a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown arr-drop">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Выберите
                        город
                    </button>
                    <ul class="dropdown-menu drop-down-find">
                        <li>
                            <input type="text" class="find">
                        </li>
                        <li>
                            <a href="#">Киев</a>
                        </li>
                        <li>
                            <a href="#">Днепр</a>
                        </li>
                        <li>
                            <a href="#">Харьков</a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown large-picker">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">21.08.2017 -
                        21.08.2017
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">
                                Oggi
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Leri
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Settimana
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                30 giorni
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Messe attuale
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Mese precedente
                            </a>
                        </li>
                        <li>
                            <a href="#"></a>
                        </li>
                    </ul>
                </div>
            </form>
            -->

            <div class="manager-history">
                <div class="manager-history-header">
                    <ul class="orders-title-block flex">
                        <li class="order-id">
                            <span>№</span>
                        </li>
                        <li class="application-date">
                            <span>Дата заявки</span>
                        </li>
                        <li>
                            <span>Имя</span>
                        </li>
                        <li>
                            <span>Дата ответа</span>
                        </li>
                        <li>
                            <span>Город</span>
                        </li>
                        <li>
                            <span>Статус</span>
                        </li>
                    </ul>
                </div>
                <div class="manager-history-list">

                    <?php if (!empty($orders)): ?>

                        <?php foreach ($orders as $model): ?>

                            <div class="item" data-hash="<?= $model->id; ?>">

                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>
                                            <?= Html::a($model->id, $model->getPartnerOrderUrl()) ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $model->getCreatedTime() ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->customer->full_name ?></span>
                                    </li>
                                    <li>
                                        <span><?= $model->orderAnswer->getAnswerTime() ?></span>
                                    </li>
                                    <li><span>Москва</span></li>
                                    <li><span><?= $model['order_status'] ?></span></li>
                                </ul>

                                <div class="hidden-order-info flex">

                                    <?php $form = ActiveForm::begin([
                                        'method' => 'post',
                                        'action' => $model->getPartnerOrderOnListUrl(),
                                    ]); ?>

                                    <div class="hidden-order-in">
                                        <div class="flex-product">

                                            <?php
                                            foreach ($model->items as $item) {
                                                echo $this->render('_list_item', [
                                                    'item' => $item,
                                                ]);
                                            } ?>

                                        </div>
                                        <div class="form-wrap">

                                            <?= $form
                                                ->field($model->orderAnswer, 'answer')
                                                ->textarea(['rows' => 5]) ?>

                                            <?= $form
                                                ->field($model->orderAnswer, 'id')
                                                ->input('hidden')
                                                ->label(false) ?>

                                            <?= $form
                                                ->field($model->orderAnswer, 'order_id')
                                                ->input('hidden', ['value' => $model->id])
                                                ->label(false) ?>

                                            <?= $form->field($model, 'comment')
                                                ->textarea(['disabled' => true, 'rows' => 5]) ?>

                                            <?= $form->field($model->orderAnswer, 'results')
                                                ->textarea(['rows' => 5]) ?>

                                        </div>
                                    </div>

                                    <?= Html::submitButton('Сохранить', [
                                        'class' => 'btn btn-success',
                                        'name' => 'action-save-answer',
                                        'value' => 1
                                    ]) ?>

                                    <?php if ($model->orderAnswer->id) {
                                        echo Html::submitButton('Отправить ответ клиенту', [
                                            'class' => 'btn btn-success',
                                            'name' => 'action-send-answer',
                                            'value' => 1
                                        ]);
                                    } ?>

                                    <?php ActiveForm::end(); ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</main>