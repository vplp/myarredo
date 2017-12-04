<?php

use yii\helpers\{
    Html, Url
};

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
                            <span>Телефон</span>
                        </li>
                        <li>
                            <span>Email</span>
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

                    <?php if (!empty($models)): ?>

                        <?php foreach ($models as $model): ?>

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
                                        <span>-</span>
                                    </li>
                                    <li>
                                        <span>-</span>
                                    </li>
                                    <li>
                                        <span><?= $model->orderAnswer->getAnswerTime() ?></span>
                                    </li>
                                    <li><span>
                                            <?= ($model->city) ? $model->city->lang->title : ''; ?>
                                        </span>
                                    </li>
                                    <li><span><?= $model->getOrderStatus(); ?></span></li>
                                </ul>

                                <div class="hidden-order-info flex">
                                    <?php if ($model->isArchive()): ?>
                                        <?= $this->render('_list_item_archive', [
                                            'model' => $model,
                                        ]) ?>
                                    <?php else: ?>
                                        <?= $this->render('_list_item', [
                                            'model' => $model,
                                        ]) ?>
                                    <?php endif; ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

                <?= yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'registerLinkTags' => true,
                    'nextPageLabel' => 'Далее<i class="fa fa-angle-right" aria-hidden="true"></i>',
                    'prevPageLabel' => '<i class="fa fa-angle-left" aria-hidden="true"></i>Назад'
                ]);
                ?>

            </div>
        </div>
    </div>
</main>