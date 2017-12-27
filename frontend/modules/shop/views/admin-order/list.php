<?php

use yii\helpers\{
    Html, Url
};

/**
 * @var $modelOrder \frontend\modules\shop\models\Order
 */

$this->title = $this->context->title;

?>

<main>
    <div class="page adding-product-page">
        <div class="container large-container">

            <?= Html::tag('h1', $this->context->title); ?>

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
                            <span>Город</span>
                        </li>
                        <li>
                            <span>Статус</span>
                        </li>
                    </ul>
                </div>
                <div class="manager-history-list">

                    <?php if (!empty($models)): ?>

                        <?php foreach ($models as $modelOrder): ?>

                            <div class="item" data-hash="<?= $modelOrder->id; ?>">

                                <ul class="orders-title-block flex">
                                    <li class="order-id">
                                        <span>
                                            <?= $modelOrder->id; ?>
                                        </span>
                                    </li>
                                    <li class="application-date">
                                        <span><?= $modelOrder->getCreatedTime() ?></span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->customer->full_name ?></span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->customer->phone ?></span>
                                    </li>
                                    <li>
                                        <span><?= $modelOrder->customer->email ?></span>
                                    </li>
                                    <li><span>
                                            <?= ($modelOrder->city) ? $modelOrder->city->lang->title : ''; ?>
                                        </span>
                                    </li>
                                    <li><span><?= $modelOrder->getOrderStatus(); ?></span></li>
                                </ul>

                                <div class="hidden-order-info flex">

                                    <?= $this->render('_list_item', [
                                        'modelOrder' => $modelOrder,
                                    ]) ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

                <?= frontend\components\LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>

            </div>
        </div>
    </div>
</main>